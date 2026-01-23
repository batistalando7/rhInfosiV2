@extends('layouts.admin.layout')
@section('title', 'Editar Especialidade')
@section('content')

<div class="card mb-4 mt-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-pencil me-2"></i>Editar Especialidade</span>
    <a href="{{ route('admin.specialties.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todas">
      <i class="fa-solid fa-list"></i>
    </a>
  </div>
  <div class="card-body">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form method="POST" action="{{ route('admin.specialties.update', $data->id) }}">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <div class="form-floating">
              <input type="text" name="name" class="form-control" id="name" placeholder="" value="{{ old('name', $data->name) }}">
              <label for="name">Nome da Especialidade</label>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-floating">
              <textarea name="description" class="form-control" id="description" style="height: 100px;">{{ old('description', $data->description) }}</textarea>
              <label for="description">Descrição (opcional)</label>
            </div>
          </div>

          <div class="d-grid gap-2 col-6 mx-auto mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="fas fa-save me-2"></i>Salvar Alterações
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection