<?php

namespace App\Events;

use App\Models\ChatMessage;
use App\Models\Admin;
use App\Models\Employeee;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class NewChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatMessage;

    public function __construct(ChatMessage $chatMessage)
    {
        $this->chatMessage = $chatMessage;
    }

    public function broadcastOn()
    {
        return new Channel('chat-group.' . $this->chatMessage->chatGroupId);
    }

    public function broadcastWith()
    {
        $senderName = 'Usuário';

        if ($this->chatMessage->senderType === 'admin') {
            $admin = Admin::find($this->chatMessage->senderId);

            if ($admin) {
                // Diretor: usa directorName se existir
                if ($admin->role === 'director' && !empty($admin->directorName)) {
                    $senderName = $admin->directorName;
                }
                // Chefe de departamento: usa o nome do funcionário vinculado
                elseif ($admin->role === 'department_head' && $admin->employee && !empty($admin->employee->fullName)) {
                    $senderName = $admin->employee->fullName;
                }
                // Fallback: email
                else {
                    $senderName = $admin->email;
                }
            }
        }
        elseif ($this->chatMessage->senderType === 'employeee') {
            $employee = Employeee::find($this->chatMessage->senderId);
            $senderName = $employee?->fullName ?? $this->chatMessage->senderEmail ?? 'Usuário';
        }

        $photoUrl = $this->chatMessage->senderType === 'admin'
            ? asset('images/admin-default.png')
            : asset('images/employee-default.png');

        return [
            'id'          => $this->chatMessage->id,
            'chatGroupId' => $this->chatMessage->chatGroupId,
            'senderId'    => $this->chatMessage->senderId,
            'senderType'  => $this->chatMessage->senderType,
            'senderName'  => $senderName,
            'photoUrl'    => $photoUrl,
            'message'     => $this->chatMessage->message,
            'created_at'  => $this->chatMessage->created_at->toDateTimeString(),
        ];
    }
}