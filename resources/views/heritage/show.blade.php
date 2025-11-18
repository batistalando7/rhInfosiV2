@extends('layouts.admin.layout')
@section('title', 'Detalhes do Patrimônio')

@section('content')
<div class="card mb-4">
  <div class="card-header bg-secondary text-white d-flex justify-content-between">
    <span><i class="fas fa-building me-2"></i> Detalhes do Patrimônio: {{ $heritage->Description }}</span>
    <div>
      <a href="{{ route('heritage.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-arrow-left"></i> Voltar</a>
      <a href="{{ route('heritage.edit', $heritage->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
    </div>
  </div>
  <div class="card-body">
    <dl class="row">
      <dt class="col-sm-3">Descrição do Patrimônio</dt>
      <dd class="col-sm-9">{{ $heritage->Description }}</dd>
      <dt class="col-sm-3">Tipo de Patrimônio</dt>
      <dd class="col-sm-9">{{ $heritage->Type }}</dd>
      <dt class="col-sm-3">Valor do Patrimônio</dt>
      <dd class="col-sm-9">{{ number_format($heritage->Value, 2) }} AKZ</dd>
      <dt class="col-sm-3">Data de Aquisição</dt>
      <dd class="col-sm-9">{{ $heritage->AcquisitionDate->format('d/m/Y') }}</dd>
      <dt class="col-sm-3">Localização do Patrimônio</dt>
      <dd class="col-sm-9">{{ $heritage->Location }}</dd>
      <dt class="col-sm-3">Responsável</dt>
      <dd class="col-sm-9">{{ $heritage->responsible->name ?? 'N/A' }}</dd>
      <dt class="col-sm-3">Estado do Patrimônio</dt>
      <dd class="col-sm-9"><span class="badge bg-{{ $heritage->Condition == 'novo' ? 'success' : ($heritage->Condition == 'usado' ? 'warning' : 'danger') }}">{{ ucfirst($heritage->Condition) }}</span></dd>
      <dt class="col-sm-3">Observações Adicionais</dt>
      <dd class="col-sm-9">{{ $heritage->Observations ?? '—' }}</dd>
    </dl>

    <!-- Histórico de Manutenção -->
    <h5 class="mt-4">Histórico de Manutenção</h5>
    <a href="#" data-bs-toggle="modal" data-bs-target="#maintenanceModal" class="btn btn-success btn-sm mb-2">+ Adicionar Manutenção</a>
    <table class="table table-sm">
      <thead><tr><th>Data da Manutenção</th><th>Descrição da Manutenção</th><th>Responsável pela Manutenção</th></tr></thead>
      <tbody>
        @forelse($heritage->maintenances as $m)
          <tr><td>{{ $m->MaintenanceDate->format('d/m/Y') }}</td><td>{{ $m->MaintenanceDescription }}</td><td>{{ $m->MaintenanceResponsible }}</td></tr>
        @empty
          <tr><td colspan="3">Nenhuma manutenção.</td></tr>
        @endforelse
      </tbody>
    </table>

    <!-- Transferência de Propriedade -->
    <h5 class="mt-4">Transferência de Propriedade</h5>
    <a href="#" data-bs-toggle="modal" data-bs-target="#transferModal" class="btn btn-info btn-sm mb-2">+ Adicionar Transferência</a>
    <table class="table table-sm">
      <thead><tr><th>Data da Transferência</th><th>Motivo da Transferência</th><th>Responsável pela Transferência</th></tr></thead>
      <tbody>
        @forelse($heritage->transfers as $t)
          <tr><td>{{ $t->TransferDate->format('d/m/Y') }}</td><td>{{ $t->TransferReason }}</td><td>{{ $t->TransferResponsible }}</td></tr>
        @empty
          <tr><td colspan="3">Nenhuma transferência.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Manutenção -->
<div class="modal fade" id="maintenanceModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar Manutenção</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('heritage.maintenance.store', $heritage->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label>Data da Manutenção</label>
            <input type="date" name="MaintenanceDate" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Descrição da Manutenção</label>
            <textarea name="MaintenanceDescription" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label>Responsável pela Manutenção</label>
            <input type="text" name="MaintenanceResponsible" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Transferência -->
<div class="modal fade" id="transferModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar Transferência</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('heritage.transfer.store', $heritage->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label>Data da Transferência</label>
            <input type="date" name="TransferDate" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Motivo da Transferência</label>
            <textarea name="TransferReason" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label>Responsável pela Transferência</label>
            <input type="text" name="TransferResponsible" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection