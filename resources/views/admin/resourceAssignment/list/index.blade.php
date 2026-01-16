@extends('layouts.admin.layout')
@section('title', 'Artibuiçaõo de Recursos')
@section('content')
<div class="card mb-4 shadow">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-truck me-2"></i>Todos os Recursos Atribuidos</span>
        <div>
            <a href="{{ route('admin.resourceAssignments.pdfAll', request()->only('startDate', 'endDate')) }}" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">
                <i class="fas fa-file-pdf"></i> Baixar PDF ({{ request()->filled('startDate') || request()->filled('endDate') ? 'Filtrado' : 'Todos' }})
            </a>
            <a href="{{ route('admin.resourceAssignments.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Nova Viatura">
                <i class="fas fa-plus-circle"></i> Novo
            </a>
        </div>
    </div>
    <form method="GET" action="{{ route('admin.resourceAssignments.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="form-floating">
                <input type="date" name="startDate" class="form-control" value="{{ request('startDate') }}">
                <label class="form-label">Data Início</label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-floating">
                <input type="date" name="endDate" class="form-control" value="{{ request('endDate') }}">
                <label class="form-label">Data Fim</label>
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filtrar</button>
        </div>
    </form>
    <div class="card-body">
        @if (session('msg'))
            <div class="alert alert-success">{{ session('msg') }}</div>
        @endif
        <div class="table-responsive">
            <table id="datatablesSimple" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Matrícula</th>
                        <th>Modelo</th>
                        <th>Status</th>
                        <th>Quilometragem Atual</th>
                        <th>Próxima Manut.</th>
                        <th>Motorista</th>
                        <th style="width: 58px">Acções</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resourceAssignments as $v)
                        <tr>
                            <td>{{ $v->id }}</td>
                            <td>{{ $v->plate }}</td>
                            <td>{{ $v->model }}</td>
                            <td>{{ $v->status == 'Available' ? 'Disponível' : ($v->status == 'UnderMaintenance' ? 'Em manutenção' : 'Indisponível') }}</td>
                            <td>{{ number_format($v->currentMileage ?? 0, 0, ',', '.') }} km</td>
                            <td>{{ $v->nextMaintenanceDate ? \Carbon\Carbon::parse($v->nextMaintenanceDate)->format('d/m/Y') : '-' }}</td>
                            <td>
                                @forelse ($v->drivers as $d)
                                    {{ $d->fullName }}@if(!$loop->last), @endif
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td>
                                <a href="{{ route('admin.vehicles.show', $v->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.vehicles.edit', $v->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil"></i></a>
                                <a href="#" data-url="{{ route('admin.vehicles.destroy', $v->id) }}" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection