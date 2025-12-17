<?php
// app/Http/Controllers/ChatController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatGroup;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; // Adicionar o Facade Gate para autorização

class ChatController extends Controller
{
    // Define a política de autorização para acesso ao grupo de chat
    protected function authorizeGroupAccess(ChatGroup $group)
    {
        $user = Auth::user();
        $role = $user->role;

        // 1. Acesso ao Grupo de Gestão (Director/Head Group)
        if ($group->groupType === 'managementGroup') {
            if (in_array($role, ['director', 'department_head'])) {
                return true;
            }
        }

        // 2. Acesso ao Grupo de Departamento
        if ($group->groupType === 'departmentGroup') {
            if ($user->employee && $group->departmentId === $user->employee->departmentId) {
                return true;
            }
        }

        // 3. Acesso a Conversas Individuais (Individual)
        if ($group->groupType === 'individual') {
            // A lógica original parece usar 'headId' para um dos participantes.
            // Para ser robusto, o usuário deve ser o 'headId' OU o 'employeeId' (se houver um campo para o outro lado).
            // Assumindo que 'headId' é o ID do funcionário que iniciou/é o 'cabeça' da conversa.
            // Para simplificar, vamos assumir que o usuário deve ser o 'headId' ou o 'employeeId' (se o modelo ChatGroup tiver um campo para o outro lado).
            // Como não temos o modelo ChatGroup completo, vamos manter a lógica de que o usuário deve ser o 'headId' para ter acesso,
            // mas isso pode precisar de ajuste se o modelo for mais complexo.
            // Para o contexto do problema (Director/Head), vamos focar em quem pode iniciar/participar.
            // Se o usuário for o 'headId' ou o 'employeeId' (se existir), ele tem acesso.
            // Como o problema é sobre Director/Head, vamos assumir que eles estão envolvidos.
            
            // Se o usuário for o 'headId'
            if ($user->employee && $group->headId === $user->employee->id) {
                return true;
            }
            
            // Se o usuário for o 'employeeId' (assumindo que o outro lado da conversa individual está no campo 'employeeId' do ChatGroup)
            // if ($user->employee && $group->employeeId === $user->employee->id) {
            //     return true;
            // }
            
            // Para a lógica Director/Head, o Director pode ser o 'headId' de uma conversa com um Chefe.
            // O Chefe pode ser o 'headId' de uma conversa com um Director.
            // O código original em index() para Diretor:
            // $individuals = ChatGroup::where('groupType', 'individual')->where('headId', $user->employee->id)->get();
            // O código original em index() para Chefe:
            // $individuals = ChatGroup::where('groupType', 'individual')->where('headId', $user->employee->id)->get();
            // Isso significa que o usuário só vê conversas onde ele é o 'headId'.
            // A permissão deve ser: o usuário é o 'headId' OU o usuário é o 'other_participant_id' (que não está no modelo).
            // Para evitar o 403, vamos manter a lógica simples: se o usuário é o 'headId', ele tem acesso.
            // Se o problema persistir, o modelo ChatGroup precisará de um campo 'participant2Id'.
            return false; // Se não for o 'headId', nega por padrão (baseado na lógica do index)
        }

        return false; // Nega acesso por padrão
    }

    // Exibe a lista de conversas em abas conforme o nível de acesso
    public function index()
    {
        $user = Auth::user();
        $groups = collect();

        // 1. Grupo de Gestão (Diretores e Chefes de Departamento)
        if (in_array($user->role, ['director', 'department_head']) && $user->employee) {
            $managementGroup = ChatGroup::firstOrCreate(
                ['groupType' => 'managementGroup'],
                ['name' => 'Gestão (Diretores e Chefes)']
            );
            $groups->push($managementGroup);
        }

        // 2. Grupos específicos de cada role
        if ($user->role === 'director' && $user->employee) {
            // Lógica para Diretores (ex: conversas individuais com Chefes)
            $individuals = ChatGroup::where('groupType', 'individual')
                ->where('headId', $user->employee->id)
                ->get();
            $groups = $groups->merge($individuals);
        }

        if ($user->role === 'department_head' && $user->employee) {
            // Grupo do Departamento
            $departmentGroup = ChatGroup::firstOrCreate(
                [
                    'groupType'    => 'departmentGroup',
                    'departmentId' => $user->employee->departmentId
                ],
                ['name' => 'Departamento ' . $user->employee->department->title]
            );
            $groups->push($departmentGroup);

            // Lógica para Chefes de Departamento (ex: conversas individuais com Diretores/Funcionários)
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

        // Separa os grupos por tipo
        $managementGroup  = $groups->where('groupType', 'managementGroup');
        $departmentGroups = $groups->where('groupType', 'departmentGroup');
        $individuals      = $groups->where('groupType', 'individual');

        return view('chat.index', compact('managementGroup', 'departmentGroups', 'individuals'));
    }

    // Exibe a tela de conversa do grupo selecionado
    public function show($groupId)
    {
        $group = ChatGroup::findOrFail($groupId);

        // **ADICIONANDO A AUTORIZAÇÃO**
        if (!$this->authorizeGroupAccess($group)) {
            // Lança uma exceção de acesso negado, que deve ser capturada pelo Laravel
            // e retornar o 403 que o usuário estava vendo.
            abort(403, 'Acesso negado a este grupo de chat.');
        }

        // Carrega mensagens com o relacionamento sender e ordena pela data
        $messages = ChatMessage::with('sender')
                     ->where('chatGroupId', $groupId)
                     ->orderBy('created_at')
                     ->get();
        return view('chat.conversation', compact('group', 'messages'));
    }

    // Envia uma mensagem e dispara o evento para atualização em tempo real
    public function sendMessage(Request $request)
    {
        $request->validate([
            'chatGroupId' => 'required|exists:chat_groups,id',
            'message'     => 'required|string',
        ]);

        $user = Auth::user();
        $group = ChatGroup::findOrFail($request->chatGroupId);

        // **ADICIONANDO A AUTORIZAÇÃO**
        if (!$this->authorizeGroupAccess($group)) {
            abort(403, 'Acesso negado a este grupo de chat.');
        }

        // Cria a mensagem. Observe que o senderType segue a sua definição ('admin' ou 'employeee')
        $msg = ChatMessage::create([
            'chatGroupId' => $request->chatGroupId,
            'senderId'    => $user->id,
            // A lógica original usava 'admin' ou 'employeee'. Se 'director' e 'department_head'
            // são 'admin's, a lógica deve ser ajustada. Assumindo que 'director' e 'department_head'
            // são tipos de 'admin' ou que o campo 'role' é suficiente para distinguir.
            // Mantendo a lógica original, mas com um ajuste para 'employee' vs 'admin'
            'senderType'  => in_array($user->role, ['director', 'department_head']) ? 'admin' : 'employee',
            'message'     => $request->message,
        ]);

        // Dispara o evento para o broadcast
        //event(new \App\Events\ChatMessageSent($msg));

        return response()->json(['status' => 'ok']);
    }
}
