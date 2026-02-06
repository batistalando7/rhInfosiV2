@extends('layouts.admin.layout')
@section('title', 'Materiais')

@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-tools me-2"></i> Materiais de Infraestrutura</span>
            <a href="{{ route('materials.create') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-plus-circle me-1"></i> Novo Material
            </a>
        </div>
        <div class="card-body">
            @if (session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Nº Série</th>
                        <th>Modelo</th>
                        <th>Estoque</th>
                        <th style="width: 100px;" class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materials as $m)
                        <tr>
                            <td>{{ $m->Name }}</td>
                            <td>{{ $m->type->name }}</td>
                            <td>{{ $m->SerialNumber }}</td>
                            <td>{{ $m->Model }}</td>
                            <td>{{ $m->CurrentStock }}</td>
                            <td class="text-center">
                                <a href="{{ route('materials.show', $m->id) }}" class="btn btn-sm btn-info"
                                    title="Ver"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('materials.edit', $m->id) }}" class="btn btn-sm btn-warning"
                                    title="Editar"><i class="fas fa-pencil"></i></a>
                                <a href="#" data-url="{{ route('materials.destroy', $m->id) }}"
                                    class="btn btn-sm btn-danger delete-btn" title="Remover"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhum material cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
