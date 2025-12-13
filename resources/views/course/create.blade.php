@extends('layouts.admin.layout')
@section('title', 'Novo Curso')
@section('content')

<div class="card mb-4 mt-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-plus-circle me-2"></i>Novo Curso</span>
    <a href="{{ route('course.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="fa-solid fa-list"></i>
    </a>
  </div>
  <div class="card-body">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form method="POST" action="{{ route('course.store') }}">
          @csrf

          <div class="mb-3">
            <div class="form-floating">
              <input type="text" name="name" class="form-control" id="name" placeholder="" value="{{ old('name') }}">
              <label for="name">Nome do Curso</label>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-floating">
              <textarea name="description" class="form-control" id="description" style="height: 100px;">{{ old('description') }}</textarea>
              <label for="description">Descrição</label>
            </div>
          </div>

          <div class="d-grid gap-2 col-6 mx-auto mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="fas fa-check-circle me-2"></i>Cadastrar Curso
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection