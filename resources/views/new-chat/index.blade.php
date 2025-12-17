@extends('layouts.admin.chat-layout')

@section('content')
<!-- Botão para voltar ao Dashboard -->
<div class="mb-3">
  <a href="{{ route('dashboard') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Voltar para o Dashboard
  </a>
</div>

<h2 class="mb-4">Novo Chat - Lista de Conversas</h2>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  {{-- A aba de Diretores só aparece se o usuário for Diretor E o grupo de gestão existir --}}
  @if(Auth::user()->role === 'director' && $directorGroup->isNotEmpty())
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="directors-tab" data-bs-toggle="tab" data-bs-target="#tab-directors" type="button" role="tab">
        Diretores
      </button>
    </li>
  @endif

  {{-- A aba de Chefes de Departamento só aparece se o usuário for Chefe E o grupo de gestão existir --}}
  @if(Auth::user()->role === 'department_head' && $departmentHeadsGroup->isNotEmpty())
    <li class="nav-item" role="presentation">
      <button class="nav-link {{ Auth::user()->role !== 'director' ? 'active' : '' }}" id="dept-heads-tab" data-bs-toggle="tab" data-bs-target="#tab-dept-heads" type="button" role="tab">
        Chefes de Departamento
      </button>
    </li>
  @endif

  @if($departmentGroups->isNotEmpty())
    <li class="nav-item" role="presentation">
      <button class="nav-link {{ ($directorGroup->isEmpty() && $departmentHeadsGroup->isEmpty()) ? 'active' : '' }}" id="dept-tab" data-bs-toggle="tab" data-bs-target="#tab-dept" type="button" role="tab">
        Departamento
      </button>
    </li>
  @endif

  @if($individuals->isNotEmpty())
    <li class="nav-item" role="presentation">
      <button class="nav-link {{ ($directorGroup->isEmpty() && $departmentHeadsGroup->isEmpty() && $departmentGroups->isEmpty()) ? 'active' : '' }}" id="individual-tab" data-bs-toggle="tab" data-bs-target="#tab-individual" type="button" role="tab">
        Conversas Individuais
      </button>
    </li>
  @endif
</ul>

<div class="tab-content mt-3">
  {{-- Conteúdo da aba Diretores (Grupo de Gestão para Diretores) --}}
  @if(Auth::user()->role === 'director' && $directorGroup->isNotEmpty())
    <div class="tab-pane fade show active" id="tab-directors" role="tabpanel" aria-labelledby="directors-tab">
      <ul class="list-group">
        @foreach($directorGroup as $g)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('new-chat.show', $g->id) }}">
              {{ $g->name }}
            </a>
            <span class="badge bg-primary">{{ $g->messages()->count() }}</span>
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Conteúdo da aba Chefes de Departamento (Grupo de Gestão para Chefes) --}}
  @if(Auth::user()->role === 'department_head' && $departmentHeadsGroup->isNotEmpty())
    <div class="tab-pane fade {{ Auth::user()->role !== 'director' ? 'show active' : '' }}" id="tab-dept-heads" role="tabpanel" aria-labelledby="dept-heads-tab">
      <ul class="list-group">
        @foreach($departmentHeadsGroup as $g)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('new-chat.show', $g->id) }}">
              {{ $g->name }}
            </a>
            <span class="badge bg-primary">{{ $g->messages()->count() }}</span>
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  @if($departmentGroups->isNotEmpty())
    <div class="tab-pane fade {{ ($directorGroup->isEmpty() && $departmentHeadsGroup->isEmpty()) ? 'show active' : '' }}" id="tab-dept" role="tabpanel" aria-labelledby="dept-tab">
      <ul class="list-group">
        @foreach($departmentGroups as $g)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('new-chat.show', $g->id) }}">
              {{ $g->name }}
            </a>
            <span class="badge bg-primary">{{ $g->messages()->count() }}</span>
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  @if($individuals->isNotEmpty())
    <div class="tab-pane fade {{ ($directorGroup->isEmpty() && $departmentHeadsGroup->isEmpty() && $departmentGroups->isEmpty()) ? 'show active' : '' }}" id="tab-individual" role="tabpanel" aria-labelledby="individual-tab">
      <ul class="list-group">
        @foreach($individuals as $g)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('new-chat.show', $g->id) }}">
              {{ $g->name }}
            </a>
            <span class="badge bg-primary">{{ $g->messages()->count() }}</span>
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  @if($directorGroup->isEmpty() && $departmentHeadsGroup->isEmpty() && $departmentGroups->isEmpty() && $individuals->isEmpty())
    <div class="mt-3">
      <p>Não há conversas/grupos disponíveis para você.</p>
    </div>
  @endif
</div>
@endsection
