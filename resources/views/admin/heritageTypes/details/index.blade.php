@extends('layouts.admin.layout')
@section('title', 'Ver Tipo de Património')

@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-eye me-2"></i> Detalhes do Tipo de Património</span>
            <div>
                <a href="{{ route('admin.heritageTypes.index') }}" class="btn btn-outline-light btn-sm" title="Voltar à Lista">
                    <i class="fa-solid fa-list"></i>
                </a>
                <a href="{{ route('admin.heritageTypes.edit', $type->id) }}" class="btn btn-warning btn-sm" title="Editar">
                    <i class="fas fa-pencil"></i>
                </a>
                <a href="#" data-url="{{ route('admin.heritageTypes.destroy', $type->id) }}"
                    class="btn btn-danger btn-sm delete-btn" title="Remover">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered mb-0">
                <tr>
                    <th>Nome</th>
                    <td>{{ $type->name }}</td>
                </tr>
                <tr>
                    <th>Descrição</th>
                    <td>{{ $type->description ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Criado em</th>
                    <td>{{ $type->created_at->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Atualizado em</th>
                    <td>{{ $type->updated_at->format('d/m/Y') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
