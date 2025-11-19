@extends('layouts.admin.layout')
@section('title', 'Detalhes do Patrimônio')

@section('content')
<div class="card mb-4">
  <div class="card-header bg-secondary text-white d-flex justify-content-between">
    <span><i class="fas fa-building me-2"></i> Detalhes do Patrimônio: {{ $heritage->Description }}</span>
    <div>
      <a href="{{ route('heritage.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-arrow-left"></i> Voltar</a>
      <a href="{{ route('heritage.edit', $heritage->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
      <a href="#" data-url="{{ route('heritage.destroy', $heritage->id) }}" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></a>
    </div>
  </div>
  <div class="card-body">
    <h5>Informações do Patrimônio</h5>
    <dl class="row mb-4">
      <dt class="col-sm-3">Descrição do Patrimônio</dt>
      <dd class="col-sm-9">{{ $heritage->Description }}</dd>
      <dt class="col-sm-3">Tipo de Patrimônio</dt>
      <dd class="col-sm-9">{{ $heritage->Type }}</dd>
      <dt class="col-sm-3">Valor do Patrimônio</dt>
      <dd class="col-sm-9">{{ number_format($heritage->Value, 2) }} AKZ</dd>
      <dt class="col-sm-3">Data de Aquisição</dt>
      <dd class="col-sm-9">{{ $heritage->AcquisitionDate->format('d/m/Y') }}</dd>
    </dl>

    <h5>Localização do Patrimônio</h5>
    <dl class="row mb-4">
      <dt class="col-sm-3">Localização</dt>
      <dd class="col-sm-9">{{ $heritage->Location }}</dd>
      <dt class="col-sm-3">Responsável</dt>
      <dd class="col-sm-9">{{ $heritage->responsible->name ?? 'N/A' }}</dd>
    </dl>

    <h5>Estado do Patrimônio</h5>
    <dl class="row mb-4">
      <dt class="col-sm-3">Condição</dt>
      <dd class="col-sm-9"><span class="badge bg-{{ $heritage->Condition == 'novo' ? 'success' : ($heritage->Condition == 'usado' ? 'warning' : 'danger') }}">{{ ucfirst($heritage->Condition) }}</span></dd>
      <dt class="col-sm-3">Observações</dt>
      <dd class="col-sm-9">{{ $heritage->Observations ?? '—' }}</dd>
    </dl>

    <h5>Responsável pelo Formulário</h5>
    <dl class="row mb-4">
      <dt class="col-sm-3">Nome</dt>
      <dd class="col-sm-9">{{ $heritage->FormResponsibleName }}</dd>
      <dt class="col-sm-3">Telefone</dt>
      <dd class="col-sm-9">{{ $heritage->FormResponsiblePhone ?? '—' }}</dd>
      <dt class="col-sm-3">Email</dt>
      <dd class="col-sm-9">{{ $heritage->FormResponsibleEmail }}</dd>
      <dt class="col-sm-3">Data do Formulário</dt>
      <dd class="col-sm-9">{{ $heritage->FormDate->format('d/m/Y') }}</dd>
    </dl>

    <h5>Histórico de Manutenção</h5>
    <a href="#" data-bs-toggle="modal" data-bs-target="#maintenanceModal" class="btn btn-success btn-sm mb-2">+ Adicionar Manutenção</a>
    <table class="table table-sm">
      <thead><tr><th>Data da Manutenção</th><th>Descrição da Manutenção</th><th>Responsável pela Manutenção</th></tr></thead>
      <tbody>
        @forelse($heritage->maintenances as $m)
          <tr><td>{{ $m->MaintenanceDate->format('d/m/Y') }}</td><td>{{ $m->MaintenanceDescription }}</td><td>{{ $m->MaintenanceResponsible }}</td></tr>
        @empty
          <tr><td colspan="3">Nenhuma manutenção registrada.</td></tr>
        @endforelse
      </tbody>
    </table>

    <h5>Transferência de Propriedade</h5>
    <a href="#" data-bs-toggle="modal" data-bs-target="#transferModal" class="btn btn-info btn-sm mb-2">+ Adicionar Transferência</a>
    <table class="table table-sm">
      <thead><tr><th>Data da Transferência</th><th>Motivo da Transferência</th><th>Responsável pela Transferência</th></tr></thead>
      <tbody>
        @forelse($heritage->transfers as $t)
          <tr><td>{{ $t->TransferDate->format('d/m/Y') }}</td><td>{{ $t->TransferReason }}</td><td>{{ $t->TransferResponsible }}</td></tr>
        @empty
          <tr><td colspan="3">Nenhuma transferência registrada.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modals iguais à anterior, sem mudanças -->
<div class="modal fade" id="maintenanceModal">
  <!-- ... (código do modal da manutenção, igual ao anterior) -->
</div>
<div class="modal fade" id="transferModal">
  <!-- ... (código do modal da transferência, igual ao anterior) -->
</div>

<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Tem certeza que deseja remover este patrimônio?')) {
            fetch(this.dataset.url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
                .then(() => location.reload());
        }
    });
});
</script>
@endsection