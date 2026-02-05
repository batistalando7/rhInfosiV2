@extends('layouts.admin.layout')
@section('title', 'Tipos de Património')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-tags me-2"></i> Tipos de Património</span>
            <a href="{{ route('admin.heritageTypes.create') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-plus-circle me-1"></i> Novo Tipo
            </a>
        </div>
        <div class="card-body">
            @if (session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th style="width: 100px;" class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $t)
                        <tr>
                            <td>{{ $t->name }}</td>
                            <td>{{ $t->description ?? '—' }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Operações
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('admin.heritageTypes.show', $t->id) }}" class="dropdown-item">
                                                <i class="fas fa-eye"></i> Detalhes
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.heritageTypes.edit', $t->id) }}" class="dropdown-item">
                                                <i class="fas fa-pencil"></i>Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.heritageTypes.destroy', $t->id) }}" class="dropdown-item">
                                                <i class="fas fa-trash"></i>Deletar
                                            </a>
                                        </li>
                                        {{-- <li>
                                            <a href="#" data-url="{{ route('admin.heritageTypes.destroy', $t->id) }}" class="dropdown-item"
                                                 title="Remover"><i
                                                    class="fas fa-trash"></i></a>Deletar
                                        </li> --}}
                                    </ul>
                                </div>
                                {{-- <a href="{{ route('admin.heritageTypes.show', $t->id) }}" class="btn btn-sm btn-info"
                                    title="Ver"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.heritageTypes.edit', $t->id) }}" class="btn btn-sm btn-warning"
                                    title="Editar"><i class="fas fa-pencil"></i></a>
                                <a href="#" data-url="{{ route('admin.heritageTypes.destroy', $t->id) }}"
                                    class="btn btn-sm btn-danger delete-btn" title="Remover"><i class="fas fa-trash"></i></a> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Nenhum tipo de património cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
