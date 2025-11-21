@extends('layouts.admin.layout')
@section('title', 'Detalhes do Patrimônio')

@section('content')
<div class="card mb-4 shadow" style="margin-top: 1.5rem;">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-building me-2"></i> Patrimônio #{{ $heritage->id }}</span>
        <a href="{{ route('heritage.index') }}" class="btn btn-outline-light btn-sm">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Descrição:</strong> {{ $heritage->Description }}</p>
                <p><strong>Tipo:</strong> {{ $heritage->Type }}</p>
                <p><strong>Valor:</strong> {{ number_format($heritage->Value, 2, ',', '.') }} Kz</p>
                <p><strong>Aquisição:</strong> {{ $heritage->AcquisitionDate->format('d/m/Y') }}</p>
                <p><strong>Localização:</strong> {{ $heritage->Location }}</p>
                <p><strong>Condição:</strong> 
                    <span class="badge bg-{{ $heritage->Condition == 'novo' ? 'success' : ($heritage->Condition == 'usado' ? 'warning' : 'danger') }}">
                        {{ ucfirst($heritage->Condition) }}
                    </span>
                </p>
                <p><strong>Responsável:</strong> {{ optional($heritage->responsible)->name ?? $heritage->FormResponsibleName }}</p>
                <p><strong>Observações:</strong> {{ $heritage->Observations ?: '—' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Cadastrado por:</strong> {{ $heritage->FormResponsibleName }}</p>
                <p><strong>Email:</strong> {{ $heritage->FormResponsibleEmail }}</p>
                <p><strong>Data do Cadastro:</strong> {{ \Carbon\Carbon::parse($heritage->FormDate)->format('d/m/Y') }}</p>
            </div>
        </div>

        <hr class="my-4">

        <h5>Histórico de Manutenção</h5>
        @if($heritage->maintenances->count())
            <table class="table table-sm table-bordered">
                <thead><tr><th>Data</th><th>Descrição</th><th>Responsável</th></tr></thead>
                <tbody>
                    @foreach($heritage->maintenances as $m)
                    <tr>
                        <td>{{ $m->MaintenanceDate->format('d/m/Y') }}</td>
                        <td>{{ $m->MaintenanceDescription }}</td>
                        <td>{{ $m->MaintenanceResponsible }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Nenhuma manutenção registrada.</p>
        @endif

        <hr class="my-4">

        <h5>Transferências</h5>
        @if($heritage->transfers->count())
            <table class="table table-sm table-bordered">
                <thead><tr><th>Data</th><th>Motivo</th><th>Responsável</th></tr></thead>
                <tbody>
                    @foreach($heritage->transfers as $t)
                    <tr>
                        <td>{{ $t->TransferDate->format('d/m/Y') }}</td>
                        <td>{{ $t->TransferReason }}</td>
                        <td>{{ $t->TransferResponsible }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Nenhuma transferência registrada.</p>
        @endif
    </div>
</div>
@endsection