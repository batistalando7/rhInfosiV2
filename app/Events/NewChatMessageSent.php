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
        // VOLTA AO ORIGINAL: canal público (funcionava antes)
        return new Channel('chat-group.' . $this->chatMessage->chatGroupId);
    }

    public function broadcastWith()
    {
        // Resolve o nome bonito (o que tu querias)
        $senderName = 'Usuário';

        if ($this->chatMessage->senderType === 'admin') {
            $admin = Admin::find($this->chatMessage->senderId);
            if ($admin) {
                if ($admin->role === 'director' && !empty($admin->directorName)) {
                    $senderName = $admin->directorName;
                } elseif ($admin->role === 'department_head' && $admin->employee && !empty($admin->employee->fullName)) {
                    $senderName = $admin->employee->fullName;
                } else {
                    $senderName = $admin->email;
                }
            }
        } elseif ($this->chatMessage->senderType === 'employeee') {
            $employee = Employeee::find($this->chatMessage->senderId);
            $senderName = $employee?->fullName ?? $this->chatMessage->senderEmail ?? 'Usuário';
        } else {
            $senderName = $this->chatMessage->senderEmail ?? 'Usuário';
        }

        // Mantém exatamente os campos que o JS espera
        return [
            'id'          => $this->chatMessage->id,
            'chatGroupId' => $this->chatMessage->chatGroupId,
            'senderId'    => $this->chatMessage->senderId,
            'senderName'  => $senderName,                    // ← Nome bonito aqui!
            'message'     => $this->chatMessage->message,
            'created_at'  => $this->chatMessage->created_at->toDateTimeString(),
        ];
    }
}