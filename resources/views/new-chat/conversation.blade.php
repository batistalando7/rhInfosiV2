@extends('layouts.admin.chat-layout')

@section('content')
<!-- Grupo de botões para navegação -->
<div class="mb-3 d-flex justify-content-between align-items-center">
  <div>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
      <i class="fas fa-arrow-left"></i> Voltar para o Dashboard
    </a>
    <a href="{{ route('new-chat.index') }}" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Voltar para Conversas
    </a>
  </div>
</div>

<h2 class="mb-4">Conversa: {{ $group->name }}</h2>

<div class="card">
  <div class="card-body chat-body" id="chatMessages">
    @foreach($messages as $m)
      @php
          $mine = ($m->senderId === auth()->id());

          // Resolver o nome bonito (compatível com Laravel 7 / PHP 7.4)
          $name = 'Usuário';

          if ($m->senderType === 'admin') {
              $sender = \App\Models\Admin::find($m->senderId);
              if ($sender) {
                  if ($sender->role === 'director' && !empty($sender->directorName)) {
                      $name = $sender->directorName;
                  } elseif ($sender->role === 'department_head' && $sender->employee && !empty($sender->employee->fullName)) {
                      $name = $sender->employee->fullName;
                  } else {
                      $name = $sender->email;
                  }
              }
          } elseif ($m->senderType === 'employeee') {
              $employee = \App\Models\Employeee::find($m->senderId);
              $name = $employee ? ($employee->fullName ?? $m->senderEmail ?? 'Usuário') : 'Usuário';
          } else {
              $name = $m->senderEmail ?? 'Usuário';
          }
      @endphp

      <div class="mb-3 d-flex {{ $mine ? 'justify-content-end' : 'justify-content-start' }}">
        <div class="{{ $mine ? 'bubble-right' : 'bubble-left' }}">
          <strong>{{ $name }}</strong><br>
          <span>{{ $m->message }}</span><br>
          <small class="text-muted">{{ $m->created_at->format('H:i') }}</small>
        </div>
      </div>
    @endforeach
  </div>

  <div class="card-footer">
    <form id="chatForm" class="d-flex" autocomplete="off">
      @csrf
      <input type="hidden" name="chatGroupId" value="{{ $group->id }}">
      <input type="text" name="message" class="form-control me-2" placeholder="Digite sua mensagem..." required autofocus>
      <button type="submit" class="btn btn-success">
        <i class="fa fa-paper-plane"></i> Enviar
      </button>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
  .chat-body {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    height: 500px;
    overflow-y: auto;
    background: #f9f9f9;
    -webkit-overflow-scrolling: touch;
  }
  .bubble-left, .bubble-right {
    max-width: 60%;
    padding: 10px;
    border-radius: 15px;
    margin-bottom: 8px;
    word-break: break-word;
  }
  .bubble-left {
    background: #e2e2e2;
    color: #000;
  }
  .bubble-right {
    background: #007bff;
    color: #fff;
  }
</style>
@endpush

@push('scripts')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.iife.js"></script>
<script>
  Pusher.logToConsole = false;

  window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '{{ env("PUSHER_APP_KEY") }}',
    cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
    forceTLS: true
  });

  const chatBox = document.getElementById('chatMessages');

  function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  document.addEventListener('DOMContentLoaded', () => {
    scrollToBottom();
    setTimeout(scrollToBottom, 200);
  });

  // Recebe mensagens em tempo real via Pusher
  window.Echo.channel('chat-group.{{ $group->id }}')
    .listen('NewChatMessageSent', (e) => {
      const mine = (e.senderId === {{ auth()->id() }});
      const bubbleClass = mine ? 'bubble-right' : 'bubble-left';
      const alignment   = mine ? 'justify-content-end' : 'justify-content-start';
      const time = new Date(e.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

      const msgHtml = `
        <div class="mb-3 d-flex ${alignment}">
          <div class="${bubbleClass}">
            <strong>${e.senderName}</strong><br>
            <span>${e.message}</span><br>
            <small class="text-muted">${time}</small>
          </div>
        </div>
      `;
      chatBox.insertAdjacentHTML('beforeend', msgHtml);
      scrollToBottom();
    });

  // Envio da mensagem (limpa o campo após sucesso)
  document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const messageInput = this.querySelector('input[name="message"]');

    fetch("{{ route('new-chat.sendMessage') }}", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'ok') {
        messageInput.value = '';
        messageInput.focus();
      }
    })
    .catch(err => {
      console.error('Erro ao enviar mensagem:', err);
    });
  });
</script>
@endpush