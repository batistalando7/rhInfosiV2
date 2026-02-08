@extends('layouts.admin.layout')
@section('title', 'Manutenções')
@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-tools me-2"></i>Registros de Manutenção</span>
            <div>
                <a href="{{ route('admin.maintenances.pdfAll', request()->only(['startDate', 'endDate', 'type'])) }}"
                    class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-file-pdf"></i> Baixar PDF
                    ({{ request()->filled('startDate') || request()->filled('endDate') || request()->filled('type') ? 'Filtrado' : 'Todos' }})
                </a>
                <a href="{{ route('admin.maintenances.create') }}" class="btn btn-outline-light btn-sm"
                    title="Novo Registro de Manutenção">
                    Novo <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
        <form method="GET" action="{{ route('admin.maintenances.index') }}" class="row g-3 mb-4 p-3 bg-light">
            <div class="col-md-2">
                <div class="form-floating">
                    <input type="date" name="startDate" class="form-control" value="{{ request('startDate') }}">
                    <label>Data Início</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating">
                    <input type="date" name="endDate" class="form-control" value="{{ request('endDate') }}">
                    <label>Data Fim</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating">
                    <select name="type" class="form-select">
                        <option value="">Todos Tipos</option>
                        <option value="Preventive" {{ request('type') == 'Preventive' ? 'selected' : '' }}>Preventiva
                        </option>
                        <option value="Corrective" {{ request('type') == 'Corrective' ? 'selected' : '' }}>Corretiva
                        </option>
                        <option value="Repair" {{ request('type') == 'Repair' ? 'selected' : '' }}>Reparo</option>
                    </select>
                    <label>Tipo</label>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filtrar</button>
            </div>
            @if (request()->hasAny(['startDate', 'endDate', 'type']))
                <div class="col-md-4 d-flex align-items-end">
                    <a href="{{ route('admin.maintenances.index') }}" class="btn btn-secondary w-100"><i
                            class="fas fa-times"></i> Limpar</a>
                </div>
            @endif
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
                            <th>Veículo</th>
                            <th>Tipo/Subtipo</th>
                            <th>Data</th>
                            <th>Quilometragem</th>
                            <th>Custo</th>
                            <th>Responsável</th>
                            <th>Próxima Data de Manutenção</th>
                            <th style="width: 58px;">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->vehicle->plate ?? '-' }} ({{ $item->vehicle->brand ?? '-' }})</td>
                                <td>{{ $item->type == 'Preventive' ? 'Preventiva' : ($item->type == 'Corrective' ? 'Corretiva' : 'Reparo') }}
                                    / {{ $item->subType ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->maintenanceDate)->format('d/m/Y') }}</td>
                                <td>{{ number_format($item->mileage ?? 0, 0, ',', '.') }} km</td>
                                <td>{{ number_format($item->cost ?? 0, 2, ',', '.') }} Kz</td>
                                <td>{{ $item->responsibleName ?? '-' }}</td>
                                <td>{{ $item->nextMaintenanceDate ? \Carbon\Carbon::parse($item->nextMaintenanceDate)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Operações
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('admin.maintenances.show', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-eye"></i> Detalhes
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.maintenances.edit', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-pencil"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.maintenances.destroy', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-trash"></i>Deletar
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
