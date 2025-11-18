@extends('layouts.admin.layout')
@section('title','Histórico — Infraestrutura')

@section('content')
<div class="card mb-4">
  <div class="card-header bg-secondary text-white d-flex justify-content-between">
    <span><i class="fas fa-clock-history me-2"></i>Histórico — Infraestrutura</span>
    <div>
      <a href="{{ route('materials.transactions.report-in') }}" class="btn btn-sm btn-outline-light" target="_blank" rel="noopener noreferrer">
        <i class="fas fa-file-earmark-pdf"></i> PDF Entradas
      </a>
      <a href="{{ route('materials.transactions.report-out') }}" class="btn btn-sm btn-outline-light" target="_blank" rel="noopener noreferrer">
        <i class="fas fa-file-earmark-pdf"></i> PDF Saídas
      </a>
      <a href="{{ route('materials.transactions.report-all') }}" class="btn btn-sm btn-outline-light" target="_blank" rel="noopener noreferrer">
        <i class="fas fa-file-earmark-pdf"></i> PDF Total
      </a>
    </div>
  </div>
  <div class="card-body">
    <form class="row g-3 mb-3" method="GET">
      <div class="col-md-3">
        <input type="date" name="startDate" class="form-control" value="{{ request('startDate') }}">
      </div>
      <div class="col-md-3">
        <input type="date" name="endDate" class="form-control" value="{{ request('endDate') }}">
      </div>
      <div class="col-md-3">
        <select name="type" class="form-select">
          <option value="">Todos</option>
          <option value="in"  {{ request('type')=='in'?'selected':'' }}>Entrada</option>
          <option value="out" {{ request('type')=='out'?'selected':'' }}>Saída</option>
        </select>
      </div>
      <div class="col-md-3 d-grid">
        <button class="btn btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
      </div>
    </form>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Tipo</th><th>Material</th><th>Qtde</th><th>Data</th><th>Destino</th><th>Responsável</th>
        </tr>
      </thead>
      <tbody>
        @forelse($txs as $t)
          <tr>
            <td>{{ $t->TransactionType=='in'?'Entrada':'Saída' }}</td>
            <td>{{ $t->material->Name }}</td>
            <td>{{ $t->Quantity }}</td>
            <td>{{ \Carbon\Carbon::parse($t->TransactionDate)->format('d/m/Y') }}</td>
            <td>{{ $t->OriginOrDestination }}</td>
            <td>{{ $t->creator->fullName ?? 'Admin' }}</td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center">Nenhuma transação.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection