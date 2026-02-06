@extends('layouts.admin.layout')
@section('title', 'Detalhes da Transação de Património')

@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-info-circle me-2"></i> Detalhes da Transação
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped table-bordered mb-3">
                        <tr>
                            <th>Tipo de Transação</th>
                            <td><span class="badge bg-{{ $tx->TransactionType == 'in' ? 'success' : 'danger' }}">{{ $tx->TransactionType == 'in' ? 'Entrada' : 'Saída' }}</span></td>
                        </tr>
                        <tr>
                            <th>Património</th>
                            <td>{{ $tx->heritage->Name }} ({{ $tx->heritage->type->name }})</td>
                        </tr>
                        <tr>
                            <th>Quantidade</th>
                            <td>{{ $tx->Quantity }}</td>
                        </tr>
                        <tr>
                            <th>Data</th>
                            <td>{{ $tx->TransactionDate->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped table-bordered mb-3">
                        <tr>
                            <th>Origem/Destino</th>
                            <td>{{ $tx->OriginOrDestination }}</td>
                        </tr>
                        <tr>
                            <th>Departamento</th>
                            <td>{{ $tx->department->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Responsável</th>
                            <td>{{ $tx->creator->fullName ?? 'Admin' }}</td>
                        </tr>
                        <tr>
                            <th>Documentação</th>
                            <td>
                                @if ($tx->DocumentationPath)
                                    <a href="{{ asset('storage/' . $tx->DocumentationPath) }}" target="_blank" class="btn btn-sm btn-info">Ver Documento</a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5>Observações</h5>
                    <p>{{ $tx->Notes ?? 'Nenhuma observação.' }}</p>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('heritage.transactions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Voltar ao Histórico
                </a>
            </div>
        </div>
    </div>
@endsection
