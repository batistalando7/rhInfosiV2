@extends('layouts.admin.layout')
@section('title', 'Editar Curso')
@section('content')

<div class="card mt-4 mt-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-pencil me-2"></i>Editar Curso</span>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="fa-solid fa-list"></i>
    </a>
  </div>
  <div class="card-body">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
          @csrf
          @method('PUT')

          {{-- form roles --}}
          @include('forms._formRole.index')
        </form>
      </div>
    </div>
  </div>
</div>

@endsection