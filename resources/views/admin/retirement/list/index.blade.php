@extends('layouts.admin.layout')
@section('title', 'Pedidos de Reforma')
@section('content')

    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-user-check me-2"></i>Lista de Pedidos de Reforma</span>
            <div>
                <!-- PDF de todos -->
                @if (
                    !request()->filled('startDate') &&
                        !request()->filled('endDate') &&
                        (!request()->filled('status') || request('status') === 'Todos'))
                    <a href="{{ route('admin.retirements.pdf') }}" class="btn btn-outline-light btn-sm" target="_blank"
                        rel="noopener noreferrer">
                        <i class="fas fa-file-earmark-pdf"></i> Baixar PDF (Todos)
                    </a>
                @endif

                <!-- PDF filtrado -->
                @if (request()->filled('startDate') ||
                        request()->filled('endDate') ||
                        (request()->filled('status') && request('status') !== 'Todos'))
                    <a href="{{ route('admin.retirements.pdf') }}?{{ http_build_query(request()->only(['startDate', 'endDate', 'status'])) }}"
                        class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">
                        <i class="fas fa-file-earmark-pdf"></i> Baixar PDF (Filtrados)
                    </a>
                @endif

                <a href="{{ route('admin.retirements.create') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-plus-circle"></i> Novo Pedido
                </a>
            </div>
        </div>

        <div class="card-body">
            <form method="GET" class="d-flex mb-3" style="max-width:320px">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control form-control-sm rounded-start" placeholder="Pesquisar funcionário">
                <button class="btn btn-outline-primary btn-sm rounded-end">
                    <i class="fas fa-search"></i>
                </button>
            </form>


            <!-- Formulário de filtros -->
            <form method="GET" action="{{ route('admin.retirements.index') }}" class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label">Data do Pedido Início</label>
                    <input type="date" name="startDate" class="form-control" value="{{ request('startDate') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Data do Pedido Fim</label>
                    <input type="date" name="endDate" class="form-control" value="{{ request('endDate') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Todos" {{ request('status') === 'Todos' ? 'selected' : '' }}>Todos</option>
                        <option value="Aprovado"{{ request('status') === 'Aprovado' ? 'selected' : '' }}>Aprovado</option>
                        <option value="Recusado"{{ request('status') === 'Recusado' ? 'selected' : '' }}>Recusado</option>
                        <option value="Pendente"{{ request('status') === 'Pendente' ? 'selected' : '' }}>Pendente</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </form>
            <!-- /Formulário de filtros -->

            @if ($retirements->count())
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Funcionário</th>
                                <th>Data do Pedido</th>
                                <th>Data de Reforma</th>
                                <th>Status</th>
                                <th>Observações</th>
                                <th>Criado em</th>
                                <th style="width: 58px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($retirements as $item)
                                <tr>
                                    <td>{{ $item->employee->fullName ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->requestDate)->format('d/m/Y') }}</td>
                                    <td>
                                        {{ $item->retirementDate ? \Carbon\Carbon::parse($item->retirementDate)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>
                                        @if ($item->status == 'Aprovado')
                                            <span class="badge bg-success">Aprovado</span>
                                        @elseif($item->status == 'Recusado')
                                            <span class="badge bg-danger">Recusado</span>
                                        @else
                                            <span class="badge bg-warning">Pendente</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->observations ?? '-' }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Operações
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('admin.retirements.show', $item->id) }}"
                                                        class="dropdown-item">
                                                        <i class="fas fa-eye"></i> Detalhes
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.retirements.edit', $item->id) }}"
                                                        class="dropdown-item">
                                                        <i class="fas fa-pencil"></i>Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.retirements.destroy', $item->id) }}"
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
            @else
                <p class="text-center">Nenhum pedido de reforma registrado.</p>
            @endif

        </div>
    </div>

@endsection
