@extends('layouts.admin.layout')
@section('title', 'Pedidos de Férias - Área Administrativa')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Pedidos de Férias para Encaminhamento (RH)</h4>
  </div>
  <div class="card-body">

    @if(session('msg'))
      <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    {{-- FILTROS --}}
    <form method="GET" action="{{ route('admin.hr.pendingVacations') }}" class="row g-3 mb-4">
      <div class="col-md-3">
        <label for="from" class="form-label">De</label>
        <input type="date" name="from" id="from" value="{{ $from }}" class="form-control">
      </div>
      <div class="col-md-3">
        <label for="to" class="form-label">Até</label>
        <input type="date" name="to" id="to" value="{{ $to }}" class="form-control">
      </div>
      <div class="col-md-3">
        <label for="employeeId" class="form-label">Funcionário (ID)</label>
        <input type="text" name="employeeId" id="employeeId" value="{{ $employeeId }}" class="form-control" placeholder="ID do Funcionário">
      </div>
      <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-search me-1"></i>Filtrar
        </button>
        <a href="{{ route('admin.hr.pendingVacations') }}" class="btn btn-secondary">
          <i class="fas fa-sync me-1"></i>Limpar
        </a>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Funcionário</th>
            <th>Data Início</th>
            <th>Data Fim</th>
            <th>Tipo</th>
            <th>Status</th>
            <th>Retificar Início</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pendingRequests as $req)
            <tr>
              <td>{{ $req->id }}</td>
              <td>{{ $req->employee->fullName ?? '-' }}</td>
              <td>{{ \Carbon\Carbon::parse($req->vacationStart)->format('d/m/Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($req->vacationEnd)->format('d/m/Y') }}</td>
              <td>{{ $req->vacationType }}</td>
              <td><span class="badge bg-info">{{ $req->approvalStatus }}</span></td>
              <td>
                <form id="forward-form-{{ $req->id }}" action="{{ route('admin.hr.forwardVacation', $req->id) }}" method="POST">
                  @csrf
                  <input type="date" name="vacationStart" class="form-control form-control-sm" value="{{ $req->vacationStart }}">
              </td>
              <td>
                  <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-share"></i> Encaminhar
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center">Nenhum pedido validado pelo chefe de departamento.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</div>

@endsection
