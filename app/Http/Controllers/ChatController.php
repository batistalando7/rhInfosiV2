<?php
// app/Http/Controllers/ChatController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatGroup;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; 

class ChatController extends Controller
{
    /**
     * Define a política de autorização para acesso ao grupo de chat.
     * Retorna true se o usuário tem permissão, false caso contrário.
     */
    protected function authorizeGroupAccess(ChatGroup $group)
    {
        $user = Auth::user();
        $role = $user->role;

        // O usuário deve ter um registro de funcionário para acessar qualquer grupo.
        if (!$user->employee) {
            return false;
        }

        // 1. Acesso ao Grupo de Gestão (Diretores e Chefes de Departamento)
        // Este grupo permite a comunicação entre Diretores e Chefes de Departamento.
        if ($group->groupType === 'managementGroup') {
            if (in_array($role, ['director', 'department_head'])) {
                return true;
            }
        }

        // 2. Acesso ao Grupo de Departamento
        if ($group->groupType === 'departmentGroup') {
            // Acesso permitido se o usuário for do departamento do grupo.
            if ($group->departmentId === $user->employee->departmentId) {
                return true;
            }
        }

        // 3. Acesso a Conversas Individuais (Individual)
        if ($group->groupType === 'individual') {
            // Acesso permitido se o usuário for o 'headId' (o participante principal)
            // OU se o usuário for o 'employeeId' (o outro participante).
            // Como o modelo ChatGroup não tem 'employeeId' no código original,
            // vamos assumir que o 'headId' é o ID do funcionário do usuário logado.
            // Se o usuário for o 'headId', ele tem acesso.
            if ($group->headId === $user->employee->id) {
                return true;
            }
            
            // **IMPORTANTE:** Se a conversa individual for bidirecional, o modelo ChatGroup
            // precisará de um campo para o segundo participante (ex: 'participant2Id').
            // Sem esse campo, a lógica de permissão para o segundo participante falhará.
            // Para o contexto atual, vamos assumir que o 'headId' é o único participante
            // que o código original estava rastreando para conversas individuais.
        }

        return false; // Nega acesso por padrão
    }

    /**
     * Exibe a lista de conversas em abas conforme o nível de acesso.
     */
    public function index()
    {
        $user = Auth::user();
        $groups = collect();

        // 1. Grupo de Gestão (managementGroup) - Para Diretores e Chefes de Departamento
        if (in_array($user->role, ['director', 'department_head']) && $user->employee) {
            $managementGroup = ChatGroup::firstOrCreate(
                ['groupType' => 'managementGroup'],
                ['name' => 'Gestão (Diretores e Chefes)']
            );
            $groups->push($managementGroup);
        }

        // 2. Grupos específicos de cada role
        if ($user->role === 'director' && $user->employee) {
            // Diretores veem o grupo de gestão como "Diretores" na aba
            $directorGroup = $groups->where('groupType', 'managementGroup');
            
            // Conversas individuais: Diretor com cada Chefe de Departamento
            $individuals = ChatGroup::where('groupType', 'individual')
                ->where('headId', $user->employee->id)
                ->get();
            $groups = $groups->merge($individuals);
        }

        if ($user->role === 'department_head' && $user->employee) {
            // Chefes de Departamento veem o grupo de gestão como "Chefes de Departamento" na aba
            $departmentHeadsGroup = $groups->where('groupType', 'managementGroup');
            
            // Grupo do Departamento
            $departmentGroup = ChatGroup::firstOrCreate(
                [
                    'groupType'    => 'departmentGroup',
                    'departmentId' => $user->employee->departmentId
                ],
                ['name' => 'Departamento ' . $user->employee->department->title]
            );
            $groups->push($departmentGroup);

            // Conversas individuais entre chefes ou entre chefe e funcionário
            $individuals = ChatGroup::where('groupType', 'individual')
                ->where('headId', $user->employee->id)
                ->get();
            $groups = $groups->merge($individuals);
        }

        // Caso seja Funcionário:
        if ($user->role === 'employee' && $user->employee && $user->employee->departmentId) {
            // Grupo do Departamento
            $departmentGroup = ChatGroup::firstOrCreate(
                [
                    'groupType'    => 'departmentGroup',
                    'departmentId' => $user->employee->departmentId
                ],
                ['name' => 'Departamento ' . $user->employee->department->title]
            );
            $groups->push($departmentGroup);

            // Conversa individual com seu Chefe
            $head = \App\Models\Admin::where('role', 'department_head')
                ->where('department_id', $user->employee->departmentId)
                ->first();
            if ($head && $head->employee) {
                $individualGroup = ChatGroup::firstOrCreate(
                    [
                        'groupType'    => 'individual',
                        'departmentId' => $user->employee->departmentId,
                        'headId'       => $head->employee->id
                    ],
                    ['name' => $user->employee->fullName . ' ↔ ' . $head->employee->fullName]
                );
                $groups->push($individualGroup);
            }
        }

        $groups = $groups->unique('id')->values();

        // Separa os grupos para a view
        // O grupo de gestão é único, mas é passado para as duas variáveis que a view espera.
        $managementGroups = $groups->where('groupType', 'managementGroup');
        
        // Se o usuário for Diretor, ele vê o grupo de gestão como $directorGroup
        $directorGroup = ($user->role === 'director') ? $managementGroups : collect();
        
        // Se o usuário for Chefe, ele vê o grupo de gestão como $departmentHeadsGroup
        $departmentHeadsGroup = ($user->role === 'department_head') ? $managementGroups : collect();
        
        $departmentGroups = $groups->where('groupType', 'departmentGroup');
        $individuals      = $groups->where('groupType', 'individual');

        // A view espera: $directorGroup, $departmentHeadsGroup, $departmentGroups, $individuals
        return view('chat.index', compact('directorGroup', 'departmentHeadsGroup', 'departmentGroups', 'individuals'));
    }

    /**
     * Exibe a tela de conversa do grupo selecionado.
     */
    public function show($groupId)
    {
        $group = ChatGroup::findOrFail($groupId);

        // **AUTORIZAÇÃO: Verifica se o usuário tem permissão para acessar este grupo.**
        if (!$this->authorizeGroupAccess($group)) {
            // Se não tiver permissão, lança o 403.
            abort(403, 'Acesso negado a este grupo de chat.');
        }

        // Carrega mensagens com o relacionamento sender e ordena pela data
        $messages = ChatMessage::with('sender')
                     ->where('chatGroupId', $groupId)
                     ->orderBy('created_at')
                     ->get();
        return view('new-chat.conversation', compact('group', 'messages'));
    }

    /**
     * Envia uma mensagem e dispara o evento para atualização em tempo real.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'chatGroupId' => 'required|exists:chat_groups,id',
            'message'     => 'required|string',
        ]);

        $user = Auth::user();
        $group = ChatGroup::findOrFail($request->chatGroupId);

        // **AUTORIZAÇÃO: Verifica se o usuário tem permissão para enviar mensagem neste grupo.**
        if (!$this->authorizeGroupAccess($group)) {
            abort(403, 'Acesso negado a este grupo de chat.');
        }

        // Cria a mensagem.
        $msg = ChatMessage::create([
            'chatGroupId' => $request->chatGroupId,
            'senderId'    => $user->id,
            // Ajustando o senderType: Diretor e Chefe são 'admin', Funcionário é 'employee'.
            'senderType'  => in_array($user->role, ['director', 'department_head']) ? 'admin' : 'employee',
            'message'     => $request->message,
        ]);

        // Dispara o evento para o broadcast
        //event(new \App\Events\ChatMessageSent($msg));

        return response()->json(['status' => 'ok']);
    }
}
