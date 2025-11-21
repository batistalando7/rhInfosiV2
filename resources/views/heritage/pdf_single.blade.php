@extends('layouts.admin.pdf')

@section('pdfTitle', 'Ficha de Patrimônio #{{ $heritage->id }}')

@section('titleSection')
    <h4 class="text-center">FICHA INDIVIDUAL DE PATRIMÔNIO</h4>
    <h5 class="text-center text-primary">#{{ $heritage->id }} — {{ $heritage->Description }}</h5>
    <p class="text-center text-muted">Gerado em: {{ now()->format('d/m/Y \à\s H:i') }}</p>
@endsection

@section('contentTable')
    <table class="info-table">
        <tr><th>Descrição</th><td>{{ $heritage->Description }}</td></tr>
        <tr><th>Tipo</th><td>{{ $heritage->Type }}</td></tr>
        <tr><th>Valor</th><td><strong>{{ number_format($heritage->Value, 2, ',', '.') }} Kz</strong></td></tr>
        <tr><th>Data de Aquisição</th><td>{{ $heritage->AcquisitionDate->format('d/m/Y') }}</td></tr>
        <tr><th>Localização Atual</th><td>{{ $heritage->Location }}</td></tr>
        <tr><th>Condição</th><td>
            <strong>
                @if($heritage->Condition == 'novo') <span class="text-success">Novo</span>
                @elseif($heritage->Condition == 'usado') <span class="text-warning">Usado</span>
                @else <span class="text-danger">Danificado</span>
                @endif
            </strong>
        </td></tr>
        <tr><th>Responsável Atual</th><td>{{ optional($heritage->responsible)->name ?? $heritage->FormResponsibleName }}</td></tr>
        <tr><th>Observações</th><td>{{ $heritage->Observations ?: '—' }}</td></tr>
        <tr><th>Cadastrado por</th><td>{{ $heritage->FormResponsibleName }}</td></tr>
        <tr><th>Data do Cadastro</th><td>{{ \Carbon\Carbon::parse($heritage->FormDate)->format('d/m/Y') }}</td></tr>
    </table>

    @if($heritage->maintenances->count())
    <h5 class="mt-4">Histórico de Manutenção</h5>
    <table>
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
    @endif

    @if($heritage->transfers->count())
    <h5 class="mt-4">Histórico de Transferências</h5>
    <table>
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
    @endif
@endsection