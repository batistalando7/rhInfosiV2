@extends('layouts.admin.layout')
@section('title', 'Histórico de Património')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-clock-history me-2"></i> Histórico de Património</span>
            <div>
                <a href="{{ route('heritage.transactions.report-in') }}" class="btn btn-sm btn-outline-light" target="_blank"
                    rel="noopener noreferrer" title="PDF Entradas">
                    <i class="fas fa-file-earmark-pdf"></i> Entradas
                </a>
                <a href="{{ route('heritage.transactions.report-out') }}" class="btn btn-sm btn-outline-light" target="_blank"
                    rel="noopener noreferrer" title="PDF Saídas">
                    <i class="fas fa-file-earmark-pdf"></i> Saídas
                </a>
                <a href="{{ route('heritage.transactions.report-all') }}" class="btn btn-sm btn-outline-light" target="_blank"
                    rel="noopener noreferrer" title="PDF Total">
                    <i class="fas fa-file-earmark-pdf"></i> Total
                </a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-3 mb-3" method="GET">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="date" name="startDate" id="startDate" class="form-control" placeholder="Data Inicial"
                            value="{{ request('startDate') }}">
                        <label for="startDate">Data Inicial</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="date" name="endDate" id="endDate" class="form-control" placeholder="Data Final"
                            value="{{ request('endDate') }}">
                        <label for="endDate">Data Final</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating">
                        <select name="type" id="type" class="form-select">
                            <option value="">Todos</option>
                            <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Entrada</option>
                            <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Saída</option>
                        </select>
                        <label for="type">Tipo</label>
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
                </div>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Património</th>
                        <th>Qtde</th>
                        <th>Data</th>
                        <th>Origem/Destino</th>
                        <th>Responsável</th>
                        <th class="text-center">Doc</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($txs as $t)
                        <tr>
                            <td>
                                <span
                                    class="badge bg-{{ $t->TransactionType == 'in' ? 'success' : 'danger' }}">{{ $t->TransactionType == 'in' ? 'Entrada' : 'Saída' }}</span>
                            </td>
                            <td>{{ $t->heritage->Name }} ({{ $t->heritage->type->name }})</td>
                            <td>{{ $t->Quantity }}</td>
                            <td>{{ $t->TransactionDate->format('d/m/Y') }}</td>
                            <td>{{ $t->OriginOrDestination }}</td>
                            <td>{{ $t->creator->fullName ?? 'Admin' }}</td>
                            <td class="text-center">
                                @if ($t->DocumentationPath)
                                    <a href="{{ asset('storage/' . $t->DocumentationPath) }}" target="_blank"
                                        class="btn btn-sm btn-info" title="Ver Documento">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Nenhuma transação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
