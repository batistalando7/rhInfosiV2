@extends('layouts.admin.layout')
@section('title', 'Novo Funcionário')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-user-plus me-2"></i>Novo Funcionário</span>
    <a href="{{ route('admin.employeee.index') }}" class="btn btn-outline-light btn-sm" title="Ver todos">
      <i class="fa-solid fa-list"></i>
    </a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.employeee.store') }}" enctype="multipart/form-data">
      @csrf

      @include('forms._formEmployeee.index')
    </form>
  </div>
</div>

@endsection
