@extends('layouts.admin.layout')
@section('title', 'Detalhes do Produto')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-info-circle me-2"></i> Detalhes do Produto
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered mb-3">
                        <tr>
                            <th>Nome</th>
                            <td><span class="badge bg-{{ $heritage->TransactionType == 'in' ? 'success' : 'danger' }}">{{ $heritage->TransactionType == 'in' ? 'Entrada' : 'Saída' }}</span></td>
                        </tr>
                        <tr>
                            <th>Categoria</th>
                            <td>{{ $heritage->Name }} ({{ $heritage->heritageType->name }})</td>
                        </tr>
                        <tr>
                            <th>Quantidade</th>
                            <td>{{ $heritage->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Data de fabríco</th>
                            <td>{{ $heritage->manufactureDate }}</td>
                        </tr>
                    </table>
                </div>
                {{-- <div class="col-md-6">
                    <table class="table table-striped table-bordered mb-3">
                        <tr>
                            <th>Origem/Destino</th>
                            <td>{{ $heritage->OriginOrDestination }}</td>
                        </tr>
                        <tr>
                            <th>Departamento</th>
                            <td>{{ $heritage->department->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Responsável</th>
                            <td>{{ $heritage->creator->fullName ?? 'Admin' }}</td>
                        </tr>
                        <tr>
                            <th>Documentação</th>
                            <td>
                                @if ($heritage->DocumentationPath)
                                    <a href="{{ asset('storage/' . $heritage->DocumentationPath) }}" target="_blank" class="btn btn-sm btn-info">Ver Documento</a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    </table>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-12">
                    <h5>Observações</h5>
                    <p>{{ $heritage->notes ?? 'Nenhuma observação.' }}</p>
                </div>
            </div>
            {{-- <div class="text-center mt-4">
                <a href="{{ route('materials.transactions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Voltar ao Histórico
                </a>
            </div> --}}
        </div>
    </div>
@endsection
