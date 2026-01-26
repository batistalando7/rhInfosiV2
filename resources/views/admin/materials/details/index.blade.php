@extends('layouts.admin.layout')
@section('title', 'Ver Material')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-eye me-2"></i> Detalhes do Material: {{ $material->Name }}</span>
            <div>
                <a href="{{ route('materials.index') }}" class="btn btn-outline-light btn-sm" title="Voltar à Lista">
                    <i class="fa-solid fa-list"></i>
                </a>
                <a href="{{ route('materials.edit', $material->id) }}" class="btn btn-warning btn-sm" title="Editar">
                    <i class="fas fa-pencil"></i>
                </a>
                <a href="#" data-url="{{ route('materials.destroy', $material->id) }}"
                    class="btn btn-danger btn-sm delete-btn" title="Remover">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped table-bordered mb-3">
                        <tr>
                            <th>Nome</th>
                            <td>{{ $material->Name }}</td>
                        </tr>
                        <tr>
                            <th>Tipo</th>
                            <td>{{ $material->type->name }}</td>
                        </tr>
                        <tr>
                            <th>Número de Série</th>
                            <td>{{ $material->SerialNumber }}</td>
                        </tr>
                        <tr>
                            <th>Modelo</th>
                            <td>{{ $material->Model }}</td>
                        </tr>
                        <tr>
                            <th>Data de Fabrico</th>
                            <td>{{ $material->ManufactureDate->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped table-bordered mb-3">
                        <tr>
                            <th>Fornecedor</th>
                            <td>{{ $material->SupplierName }}</td>
                        </tr>
                        <tr>
                            <th>NIF do Fornecedor</th>
                            <td>{{ $material->SupplierIdentifier }}</td>
                        </tr>
                        <tr>
                            <th>Data de Entrada</th>
                            <td>{{ $material->EntryDate->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Estoque Atual</th>
                            <td><span class="badge bg-primary">{{ $material->CurrentStock }}</span></td>
                        </tr>
                        <tr>
                            <th>Observações</th>
                            <td>{{ $material->Notes ?? '—' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
