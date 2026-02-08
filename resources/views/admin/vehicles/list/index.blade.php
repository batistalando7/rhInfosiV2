@extends('layouts.admin.layout')
@section('title', 'Veículos')
@section('content')
<div class="card mt-4 shadow">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-truck me-2"></i>Todos os Veículos</span>
        <div>
            <a href="{{ route('admin.vehicles.pdfAll', request()->only('startDate', 'endDate')) }}" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">
                <i class="fas fa-file-pdf"></i> Baixar PDF ({{ request()->filled('startDate') || request()->filled('endDate') ? 'Filtrado' : 'Todos' }})
            </a>
            <a href="{{ route('admin.vehicles.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Nova Viatura">
                <i class="fas fa-plus-circle"></i> Novo
            </a>
        </div>
    </div>
    <form method="GET" action="{{ route('admin.vehicles.index') }}" class="row g-3 mb-4">
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
                        {{-- <th>Motorista</th> --}}
                        <th style="width: 58px">Acções</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->plate }}</td>
                            <td>{{ $item->model }}</td>
                            <td>{{ $item->status == 'Available' ? 'Disponível' : ($item->status == 'UnderMaintenance' ? 'Em manutenção' : 'Indisponível') }}</td>
                            <td>{{ number_format($item->currentMileage ?? 0, 0, ',', '.') }} km</td>
                            <td>{{ $item->nextMaintenanceDate ? \Carbon\Carbon::parse($v->nextMaintenanceDate)->format('d/m/Y') : '-' }}</td>
                            <td>
                                {{-- @forelse ($v->drivers as $d)
                                    {{ $d->fullName }}@if(!$loop->last), @endif
                                @empty
                                    -
                                @endforelse --}}
                            </td>
                            <td>
                                <div class="btn-group">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Operações
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('admin.vehicles.show', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-eye"></i> Detalhes
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.vehicles.edit', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-pencil"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.vehicles.destroy', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-trash"></i>Deletar
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection