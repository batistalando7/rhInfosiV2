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
        // Usa o senderEmail armazenado (como no teu original que funcionava)
        $senderName = !empty($this->chatMessage->senderEmail)
            ? $this->chatMessage->senderEmail
            : 'Usuário';

        // Mas adiciona o nome bonito resolvido (para o JS usar)
        $prettyName = 'Usuário';

        if ($this->chatMessage->senderType === 'admin') {
            $admin = Admin::find($this->chatMessage->senderId);
            if ($admin) {
                if ($admin->role === 'director' && !empty($admin->directorName)) {
                    $prettyName = $admin->directorName;
                } elseif ($admin->role === 'department_head' && $admin->employee && !empty($admin->employee->fullName)) {
                    $prettyName = $admin->employee->fullName;
                } else {
                    $prettyName = $admin->email;
                }
            }
        } elseif ($this->chatMessage->senderType === 'employeee') {
            $employee = Employeee::find($this->chatMessage->senderId);
            $prettyName = $employee ? ($employee->fullName ?? $this->chatMessage->senderEmail ?? 'Usuário') : 'Usuário';
        }

        // Foto padrão (como tinhas antes)
        $photoUrl = $this->chatMessage->senderType === 'admin'
            ? asset('images/admin-default.png')
            : asset('images/employee-default.png');

        return [
            'id'           => $this->chatMessage->id,
            'chatGroupId'   => $this->chatMessage->chatGroupId,
            'senderId'     => $this->chatMessage->senderId,
            'senderType'   => $this->chatMessage->senderType,
            'senderName'   => $senderName,         // ← Campo antigo (email) para compatibilidade
            'prettyName'   => $prettyName,         // ← Novo campo com nome bonito para o JS usar
            'photoUrl'     => $photoUrl,
            'message'      => $this->chatMessage->message,
            'created_at'   => $this->chatMessage->created_at->toDateTimeString(),
        ];
    }
}