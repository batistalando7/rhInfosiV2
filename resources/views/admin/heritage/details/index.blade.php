@extends('layouts.admin.layout')
@section('title', 'Detalhes do Produto')

@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white">
             <a href="{{ route('admin.heritages.index') }}" class="btn btn-outline-secondary border text-white">Voltar</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered mb-3">
                        <tr>
                            <th>Nome</th>
                            <td><span >{{ $heritage->name }}</span></td>
                        </tr>
                        <tr>
                            <th>Categoria</th>
                            <td>{{ $heritage->heritageType->name }}</td>
                        </tr>
                        <tr>
                            <th>Modelo</th>
                            <td>{{ $heritage->model }} ({{ $heritage->heritageType->name }})</td>
                        </tr>
                        <tr>
                            <th>Quantidade</th>
                            <td>{{ $heritage->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Fornecedor</th>
                            <td>{{ $heritage->supplier->name }}</td>
                        </tr>
                        <tr>
                            <th>Documento</th>
                            <td><a href="#document">Ver</a></td>
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
