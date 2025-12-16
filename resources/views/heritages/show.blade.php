@extends('layouts.admin.layout')
@section('title', 'Detalhes do Património')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-eye me-2"></i> Detalhes do Património: {{ $heritage->Description }}</span>
            <div>
                <a href="{{ route('heritages.index') }}" class="btn btn-outline-light btn-sm" title="Voltar à Lista">
                    <i class="fa-solid fa-list"></i>
                </a>
                <a href="{{ route('heritages.edit', $heritage->id) }}" class="btn btn-warning btn-sm" title="Editar">
                    <i class="fas fa-pencil"></i>
                </a>
                <a href="{{ route('heritages.showPdf', $heritage->id) }}" target="_blank" class="btn btn-info btn-sm" title="PDF">
                    <i class="fas fa-file-pdf"></i>
                </a>
               
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-primary">Informações Principais</h5>
                    <table class="table table-striped table-bordered mb-3">
                        <tr><th>Descrição</th><td>{{ $heritage->Description }}</td></tr>
                        <tr><th>Tipo</th><td>{{ $heritage->type->name }}</td></tr>
                        <tr><th>Valor</th><td>{{ number_format($heritage->Value, 2, ',', '.') }} Kz</td></tr>
                        <tr><th>Data de Aquisição</th><td>{{ $heritage->AcquisitionDate->format('d/m/Y') }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="text-primary">Localização e Estado Atual</h5>
                    <table class="table table-striped table-bordered mb-3">
                        <tr><th>Localização Atual</th><td>{{ $heritage->Location }}</td></tr>
                        <tr><th>Responsável Atual</th><td>{{ $heritage->ResponsibleName }}</td></tr>
                        <tr><th>Condição</th><td><span class="badge bg-{{ $heritage->Condition == 'Novo' ? 'success' : ($heritage->Condition == 'Danificado' || $heritage->Condition == 'Avariado' ? 'danger' : 'warning') }}">{{ $heritage->Condition }}</span></td></tr>
                        <tr><th>Observações</th><td>{{ $heritage->Notes ?? '—' }}</td></tr>
                    </table>
                </div>
            </div>

            <h5 class="text-primary mt-4">Histórico Completo</h5>
            
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Data</th>
                                <th>Detalhes</th>
                                <th>Responsável</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $item)
                                <tr>
                                    <td><span class="badge bg-{{ $item->type == 'Manutenção' ? 'info' : 'warning' }}">{{ $item->type }}</span></td>
                                    <td>{{ $item->type == 'Manutenção' ? $item->MaintenanceDate->format('d/m/Y') : $item->TransferDate->format('d/m/Y') }}</td>
                                    <td>
                                        @if($item->type == 'Manutenção')
                                            Custo: {{ number_format($item->MaintenanceCost, 2, ',', '.') }} Kz. Descrição: {{ Str::limit($item->Description, 60) }}
                                        @else
                                            De: {{ $item->OriginLocation }} Para: {{ $item->DestinationLocation }}. Novo Responsável: {{ $item->TransferredToName }}. Motivo: {{ Str::limit($item->Reason, 40) }}
                                        @endif
                                    </td>
                                    <td>{{ $item->ResponsibleName }}</td>
                                    <td class="text-center">
                                        @if($item->type == 'Manutenção')
                                            <a href="{{ route('heritages.maintenance.edit', ['heritage' => $heritage->id, 'maintenance' => $item->id]) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-pencil"></i></a>
                                            <a href="#" data-url="{{ route('heritages.maintenance.destroy', ['heritage' => $heritage->id, 'maintenance' => $item->id]) }}" class="btn btn-sm btn-danger delete-btn" title="Remover"><i class="fas fa-trash"></i></a>
                                        @else
                                            <a href="{{ route('heritages.transfer.edit', ['heritage' => $heritage->id, 'transfer' => $item->id]) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-pencil"></i></a>
                                            <a href="#" data-url="{{ route('heritages.transfer.destroy', ['heritage' => $heritage->id, 'transfer' => $item->id]) }}" class="btn btn-sm btn-danger delete-btn" title="Remover"><i class="fas fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">Nenhum histórico de movimentação registado.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
