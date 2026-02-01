@extends('layouts.admin.layout')
@section('title', 'Detalhes do Fornecedor')
@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-8">
            <h3><i class="fas fa-truck me-2"></i> Detalhes do Fornecedor #{{ $supplier->id }}</h3>
        </div>
        <div class="col-4 text-end">
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            {{-- <a href="{{ route('admin.suppliers.index', $supplier->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                <i class="fas fa-download"></i> Baixar PDF
            </a> --}}
        </div>
    </div>
    <div class="row mb-5 align-items-start">
        <div class="col-md-8 m-auto">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-secondary text-white">
                    <strong>Dados da Viatura</strong>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr><th class="ps-0">Nome</th><td>{{ $supplier->name }}</td></tr>
                            <tr><th class="ps-0">NIF</th><td>{{ $supplier->nif }}</td></tr>
                            <tr><th class="ps-0">Endereço</th><td>{{ $supplier->address }}</td></tr>
                            <tr><th class="ps-0">Site</th><td>{{ $supplier->site }}</td></tr>
                            <tr><th class="ps-0">Email</th><td>{{ $supplier->email }}</td></tr>
                            {{-- <tr><th class="ps-0">Capacidade</th><td>{{ $supplier->loadCapacity }}</td></tr>
                            <tr><th class="ps-0">Quilometragem Atual</th><td>{{ number_format($supplier->currentMileage ?? 0, 0, ',', '.') }} km</td></tr>
                            <tr><th class="ps-0">Status</th><td>{{ $supplier->status=='Available'?'Disponível':($supplier->status=='UnderMaintenance'?'Em manutenção':'Indisponível') }}</td></tr>
                            <tr><th class="ps-0">Observações</th><td>{{ $supplier->notes ?? '-' }}</td></tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-secondary text-white">
                    <strong>Condutores</strong>
                </div>
                <div class="card-body">
                    @forelse($supplier->drivers as $d)
                        <p>
                            {{ $d->fullName ?? ($d->employee->fullName ?? '-') }}
                            <span class="badge bg-primary">
                                {{ \Carbon\Carbon::parse($d->pivot->startDate)->format('d/m/Y') }} – {{ $d->pivot->endDate ? \Carbon\Carbon::parse($d->pivot->endDate)->format('d/m/Y') : 'Agora' }}
                            </span>
                        </p>
                    @empty
                        <p>-</p>
                    @endforelse
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <strong>Histórico de Manutenção</strong>
                </div>
                <div class="card-body">
                    <p><strong>Quilometragem Atual:</strong> {{ number_format($supplier->currentMileage ?? 0, 0, ',', '.') }} km</p>
                    <p><strong>Próxima Manutenção:</strong> {{ $supplier->nextMaintenanceDate ? \Carbon\Carbon::parse($supplier->nextMaintenanceDate)->format('d/m/Y') : '-' }}</p>
                    @forelse($supplier->maintenance->sortByDesc('maintenanceDate') as $m)
                        <p>
                            {{ \Carbon\Carbon::parse($m->maintenanceDate)->format('d/m/Y') }} – {{ $m->type == 'Preventive' ? 'Preventiva' : ($m->type == 'Corrective' ? 'Corretiva' : 'Reparo') }} ({{ $m->subType ?? '' }}) – {{ number_format($m->cost ?? 0, 2, ',', '.') }} Kz
                        </p>
                    @empty
                        <p>-</p>
                    @endforelse
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection