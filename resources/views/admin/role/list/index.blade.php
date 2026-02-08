@extends('layouts.admin.layout')
@section('title', 'Cursos')
@section('content')

    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-book me-2"></i>Todos os Cursos</span>
            <div>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Novo Curso">
                    Novo <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatablesSimple" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome do Curso</th>
                            <th>Descrição</th>
                            <th style="width: 58px;">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description ?? '-' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Operações
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('admin.roles.show', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-eye"></i> Detalhes
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.roles.edit', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-pencil"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.roles.destroy', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-trash"></i>Deletar
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <p>Nenhum registro</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
