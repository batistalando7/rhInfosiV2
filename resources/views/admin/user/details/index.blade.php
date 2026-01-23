@extends('layouts.admin.layout')
@section('title', 'Detalhes do Administrador')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-eye me-2"></i>Detalhes do Administrador: {{ $admin->email }}</span>
    <div>
      <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
        <i class="fa-solid fa-list"></i>
      </a>
      <a href="{{ route('admin.users.edit', $admin->id) }}" class="btn btn-warning btn-sm" title="Editar">
        <i class="fas fa-pencil"></i>
      </a>

      <!-- Só mostra o botão de apagar se NÃO for o super-admin (role = admin e sem employeeId) -->
      @if(!($admin->role === 'admin' && $admin->employeeId === null))
        <a href="#" data-url="{{ route('admin.users.destroy', $admin->id) }}" class="btn btn-danger btn-sm delete-btn" title="Apagar">
          <i class="fas fa-trash"></i>
        </a>
      @endif
    </div>
  </div>

  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <table class="table table-striped table-bordered mb-3">
          <tr>
            <th>ID</th>
            <td>{{ $admin->id }}</td>
          </tr>
          <tr>
            <th>Email</th>
            <td>{{ $admin->email }}</td>
          </tr>
          <tr>
            <th>Papel</th>
            <td><span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $admin->role)) }}</span></td>
          </tr>
          <tr>
            <th>Data de Criação</th>
            <td>{{ $admin->created_at->format('d/m/Y H:i') }}</td>
          </tr>
        </table>
      </div>

      <div class="col-md-6">
        <table class="table table-striped table-bordered mb-3">
          <tr>
            <th>Funcionário Vinculado</th>
            <td>
              @if($admin->employee)
                <strong>{{ $admin->employee->fullName }}</strong><br>
                <small>Email: {{ $admin->employee->email }}</small><br><br>
                <img src="{{ $admin->employee->photo ? asset('frontend/images/departments/'.$admin->employee->photo) : asset('frontend/images/default.png') }}"
                     alt="{{ $admin->employee->fullName }}"
                     class="rounded-circle shadow"
                     style="width: 120px; height: 120px; object-fit: cover;">
              @else
                <em>Nenhum funcionário vinculado</em>
              @endif
            </td>
          </tr>

          @if($admin->role === 'director')
            <tr>
              <th>Biografia</th>
              <td>{{ $admin->biography ?? '—' }}</td>
            </tr>
            <tr>
              <th>LinkedIn</th>
              <td>
                @if($admin->linkedin)
                  <a href="{{ $admin->linkedin }}" target="_blank">{{ $admin->linkedin }}</a>
                @else
                  —
                @endif
              </td>
            </tr>
          @endif
        </table>
      </div>
    </div>
  </div>
</div>

@endsection