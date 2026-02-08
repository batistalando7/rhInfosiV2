@extends('layouts.admin.layout')
@section('title', 'Estatutos')
@section('content')
    <div class="card my-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-file-earmark-text me-2"></i>Lista de Estatutos</span>
            <a href="{{ route('statutes.create') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-plus-circle"></i> Adicionar Novo
            </a>
        </div>
        <div class="card-body">
            @if (session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
            @if ($statutes->count())
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Data de Criação</th>
                            <th style="width: 58px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statutes as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Operações
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('statutes.show', $item->id) }}" class="dropdown-item">
                                                    <i class="fas fa-eye"></i> Detalhes
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('statutes.edit', $item->id) }}" class="dropdown-item">
                                                    <i class="fas fa-pencil"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('statutes.delete', $item->id) }}" class="dropdown-item">
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
            @else
                <p>Nenhum estatuto cadastrado.</p>
            @endif
        </div>
    </div>
@endsection
