<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Employeee;
use App\Models\Department;
use App\Models\ChatGroup;
use App\Models\ChatMessage;
use App\Events\NewChatMessageSent;

class NewChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $groups = collect();

        if ($user->role === 'director') {
            $directorGroup = ChatGroup::firstOrCreate(['groupType' => 'directorGroup'], ['name' => 'Diretores']);
            $groups->push($directorGroup);

            $deptHeadsGroup = ChatGroup::firstOrCreate(['groupType' => 'departmentHeadsGroup'], ['name' => 'Chefes de Departamento']);
            $groups->push($deptHeadsGroup);

            $otherDirectors = Admin::where('role', 'director')->where('id', '!=', $user->id)->get();
            foreach ($otherDirectors as $other) {
                $minID = min($user->id, $other->id);
                $maxID = max($user->id, $other->id);
                $conversationKey = 'individual_' . $minID . '_' . $maxID;

                $directorName1 = !empty($user->directorName) ? $user->directorName : $user->email;
                $directorName2 = !empty($other->directorName) ? $other->directorName : $other->email;
                $constructedName = ($user->id == $minID) ? $directorName1 . ' ↔ ' . $directorName2 : $directorName2 . ' ↔ ' . $directorName1;

                $ind = ChatGroup::firstOrCreate(
                    ['groupType' => 'individual', 'conversation_key' => $conversationKey],
                    ['name' => $constructedName]
                );
                $groups->push($ind);
            }

            $deptHeads = Admin::where('role', 'department_head')->get();
            foreach ($deptHeads as $deptHead) {
                $minID = min($user->id, $deptHead->id);
                $maxID = max($user->id, $deptHead->id);
                $conversationKey = 'individual_' . $minID . '_' . $maxID;

                $directorName = !empty($user->directorName) ? $user->directorName : $user->email;
                $deptHeadName = ($deptHead->employee && !empty($deptHead->employee->fullName)) ? $deptHead->employee->fullName : $deptHead->email;
                $constructedName = ($user->id == $minID) ? $directorName . ' ↔ ' . $deptHeadName : $deptHeadName . ' ↔ ' . $directorName;

                $ind = ChatGroup::firstOrCreate(
                    ['groupType' => 'individual', 'conversation_key' => $conversationKey],
                    ['name' => $constructedName]
                );
                $groups->push($ind);
            }
        }
        elseif ($user->role === 'department_head') {
            $deptHeadsGroup = ChatGroup::firstOrCreate(['groupType' => 'departmentHeadsGroup'], ['name' => 'Chefes de Departamento']);
            $groups->push($deptHeadsGroup);

            if (!empty($user->department_id)) {
                $departmentGroup = ChatGroup::firstOrCreate(
                    ['groupType' => 'departmentGroup', 'departmentId' => $user->department_id],
                    ['name' => 'Departamento ' . $this->getDepartmentTitle($user->department_id)]
                );
                $groups->push($departmentGroup);

                $employees = Employeee::where('departmentId', $user->department_id)->get();
                foreach ($employees as $emp) {
                    if ($emp->id != ($user->employee->id ?? 0)) {
                        $conversationKey = "individual_employee_{$emp->id}_{$user->employee->id}";
                        $ind = ChatGroup::firstOrCreate(
                            ['groupType' => 'individual', 'conversation_key' => $conversationKey],
                            [
                                'name' => $emp->fullName . ' ↔ ' . $user->employee->fullName,
                                'departmentId' => $user->department_id,
                                'headId' => $user->employee->id
                            ]
                        );
                        $groups->push($ind);
                    }
                }
            }

            $directors = Admin::where('role', 'director')->get();
            foreach ($directors as $director) {
                $minID = min($user->id, $director->id);
                $maxID = max($user->id, $director->id);
                $conversationKey = 'individual_' . $minID . '_' . $maxID;

                $directorName = !empty($director->directorName) ? $director->directorName : $director->email;
                $deptHeadName = ($user->employee && !empty($user->employee->fullName)) ? $user->employee->fullName : $user->email;
                $constructedName = ($user->id == $minID) ? $deptHeadName . ' ↔ ' . $directorName : $directorName . ' ↔ ' . $deptHeadName;

                $ind = ChatGroup::firstOrCreate(
                    ['groupType' => 'individual', 'conversation_key' => $conversationKey],
                    ['name' => $constructedName]
                );
                $groups->push($ind);
            }
        }
        elseif ($user->role === 'employee') {
            $emp = Employeee::where('email', $user->email)->first();
            if ($emp && $emp->departmentId) {
                $departmentGroup = ChatGroup::firstOrCreate(
                    ['groupType' => 'departmentGroup', 'departmentId' => $emp->departmentId],
                    ['name' => 'Departamento ' . ($emp->department->title ?? '')]
                );
                $groups->push($departmentGroup);

                $headAdmin = Admin::where('role', 'department_head')->where('department_id', $emp->departmentId)->first();
                if ($headAdmin && $headAdmin->employee) {
                    $conversationKey = "individual_employee_{$emp->id}_{$headAdmin->employee->id}";
                    $ind = ChatGroup::firstOrCreate(
                        ['groupType' => 'individual', 'conversation_key' => $conversationKey],
                        [
                            'name' => $emp->fullName . ' ↔ ' . $headAdmin->employee->fullName,
                            'departmentId' => $emp->departmentId,
                            'headId' => $headAdmin->employee->id
                        ]
                    );
                    $groups->push($ind);
                }
            }
        }

        $groups = $groups->unique('id')->values();

        $directorGroup        = $groups->where('groupType', 'directorGroup');
        $departmentHeadsGroup = $groups->where('groupType', 'departmentHeadsGroup');
        $departmentGroups     = $groups->where('groupType', 'departmentGroup');
        $individuals          = $groups->where('groupType', 'individual');

        return view('new-chat.index', compact('directorGroup', 'departmentHeadsGroup', 'departmentGroups', 'individuals'));
    }

    public function show($groupId)
    {
        $group = ChatGroup::findOrFail($groupId);
        if (!$this->userCanViewGroup($group)) {
            abort(403, 'Acesso negado a este grupo de chat.');
        }

        $messages = ChatMessage::with('sender')
            ->where('chatGroupId', $groupId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('new-chat.conversation', compact('group', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'chatGroupId' => 'required|exists:chat_groups,id',
            'message'     => 'required|string'
        ]);

        $user = Auth::user();
        $group = ChatGroup::find($request->chatGroupId);

        if (!$group || !$this->userCanViewGroup($group)) {
            return response()->json(['status' => 'forbidden'], 403);
        }

        $senderType = in_array($user->role, ['director', 'department_head', 'admin']) ? 'admin' : 'employeee';

        $msg = ChatMessage::create([
            'chatGroupId' => $group->id,
            'senderId'    => $user->id,
            'senderType'  => $senderType,
            'senderEmail' => $user->email,
            'message'     => $request->message,
        ]);

        event(new NewChatMessageSent($msg));

        return response()->json(['status' => 'ok']);
    }

    private function userCanViewGroup(ChatGroup $group): bool
    {
        $user = Auth::user();

        if ($group->groupType === 'directorGroup') return $user->role === 'director';
        if ($group->groupType === 'departmentHeadsGroup') return $user->role === 'department_head';

        if ($group->groupType === 'departmentGroup') {
            if (in_array($user->role, ['department_head', 'admin'])) return $user->department_id == $group->departmentId;
            if ($user->role === 'employee') {
                $emp = Employeee::where('email', $user->email)->first();
                return $emp && $emp->departmentId == $group->departmentId;
            }
            return false;
        }

        if ($group->groupType === 'individual' && $group->conversation_key) {
            if (str_starts_with($group->conversation_key, 'individual_') && !str_contains($group->conversation_key, 'employee')) {
                $parts = explode('_', $group->conversation_key);
                if (count($parts) === 3) {
                    $id1 = (int)$parts[1];
                    $id2 = (int)$parts[2];
                    return in_array($user->id, [$id1, $id2]);
                }
            }

            if (str_starts_with($group->conversation_key, 'individual_employee_')) {
                $parts = explode('_', $group->conversation_key);
                if (count($parts) >= 4) {
                    $empId = (int)$parts[2];
                    $headId = (int)$parts[3];
                    if ($user->role === 'employee') {
                        $currentEmp = Employeee::where('email', $user->email)->first();
                        return $currentEmp && in_array($currentEmp->id, [$empId, $headId]);
                    }
                    if ($user->role === 'department_head' && $user->employee) {
                        return in_array($user->employee->id, [$empId, $headId]);
                    }
                }
            }
        }

        $userName = $user->directorName ?? ($user->employee->fullName ?? $user->email);
        return str_contains($group->name, $userName);
    }

    private function getDepartmentTitle($deptId): string
    {
        $d = Department::find($deptId);
        return $d ? $d->title : '';
    }
}