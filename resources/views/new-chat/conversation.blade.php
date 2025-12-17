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
          // Define se a mensagem é minha para alinhar a bolha
          // Usando Auth::id() para garantir que a comparação seja correta
          $mine = ($m->senderId === Auth::id()); 
          // O campo senderEmail não existe no modelo ChatMessage, mas sim no relacionamento 'sender'.
          // Assumindo que o relacionamento 'sender' está carregado e tem um campo 'name' ou 'email'.
          // Se o relacionamento for com o modelo User/Admin, use $m->sender->name ou $m->sender->email
          $name = $m->sender->name ?? 'Usuário Desconhecido'; 
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
      <input type="text" name="message" class="form-control me-2" placeholder="Digite sua mensagem..." required>
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
    -webkit-overflow-scrolling: touch; /* ADICIONADO para iOS Safari */
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

  // Função para forçar scroll ao final
  function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  // Força o scroll para o fim assim que a página carrega
  document.addEventListener('DOMContentLoaded', () => {
    scrollToBottom();
    setTimeout(scrollToBottom, 200);
  });

  // Recebendo novas mensagens via Pusher
  window.Echo.channel('chat-group.{{ $group->id }}')
    .listen('NewChatMessageSent', (e) => {
      // Usando Auth::id() no Blade, mas aqui precisamos do ID do usuário logado no JS
      // Assumindo que você tem uma variável global com o ID do usuário logado,
      // ou que o 'e.senderId' é o ID do usuário que enviou a mensagem.
      const mine = (e.senderId === {{ Auth::id() }}); 
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

  // Envio de mensagem
  document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    // **CORREÇÃO AQUI:** Usando a rota nomeada 'new-chat.sendMessage'
    fetch("{{ route('new-chat.sendMessage') }}", {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: formData
    })
    .then(response => {
        if (!response.ok) {
            // Se a resposta não for OK (ex: 403 Forbidden), exibe o erro
            return response.json().then(err => { throw new Error(err.message || 'Erro ao enviar mensagem. Acesso negado ou erro de servidor.'); });
        }
        return response.json();
    })
    .then(data => {
      if (data.status === 'ok') {
        this.message.value = '';
      }
    })
    .catch(err => {
        console.error(err);
        alert(err.message); // Alerta o usuário sobre o erro de permissão
    });
  });
</script>
@endpush
