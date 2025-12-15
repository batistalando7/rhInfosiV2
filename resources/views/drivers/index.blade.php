@extends('layouts.admin.layout')
@section('title', 'Motoristas')
@section('content')

<div class="card mb-4 shadow">

  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-person-badge-fill me-2"></i>Todos os Motoristas</span>
    <a href="{{ route('drivers.create') }}" class="btn btn-outline-light btn-sm">
      Novo <i class="fas fa-plus-circle"></i>
    </a>
  </div>

  <div class="card-body">

   
    <form method="GET" class="d-flex mb-3" style="max-width:320px">
      <input type="text" name="search" value="{{ request('search') }}"
             class="form-control form-control-sm rounded-start"
             placeholder="Pesquisar motorista">
      <button class="btn btn-outline-primary btn-sm rounded-end">
        <i class="fas fa-search"></i>
      </button>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>B.I.</th>
          <th>Nº Carta</th>
          <th>Categoria</th>
          <th>Validade</th>
          <th>Status</th>
          <th>Ação</th>
        </tr>
        </thead>
        <tbody>
        @forelse($drivers as $d)
          <tr>
            <td>{{ $d->id }}</td>
            <td>{{ $d->employee->fullName ?? $d->fullName }}</td>
            <td>{{ $d->bi ?? '-' }}</td>
            <td>{{ $d->licenseNumber }}</td>
            <td>{{ $d->licenseCategory->name ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($d->licenseExpiry)->format('d/m/Y') }}</td>
            <td>{{ $d->status == 'Active' ? 'Ativo' : 'Inativo' }}</td>
            <td>
              <a href="{{ route('drivers.show',$d->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{ route('drivers.edit',$d->id) }}" class="btn btn-info btn-sm">
                <i class="fas fa-pencil"></i>
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center">Nenhum motorista encontrado.</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

  </div>
</div>
@endsection
