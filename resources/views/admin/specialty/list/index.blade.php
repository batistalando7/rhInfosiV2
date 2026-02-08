@extends('layouts.admin.layout')
@section('title', 'Lista de Especialidades')
@section('content')

    <div class="card mt-4 mt-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-card-list me-2"></i>Todas as Especialidades
            </span>
            <a href="{{ route('admin.specialties.create') }}" class="btn btn-outline-light btn-sm" title="Nova Especialidade">
                Nova
                <i class="fas fa-plus-circle"></i>
            </a>
        </div>
        <div class="card-body">
            <!-- Filtro para listar funcionários por Especialidade -->
            <div class="mt-4">
                <p class="mb-3 small text-muted">Listar funcionários por especialidade:</p>
                <form action="{{ route('admin.specialties.employeee.filter') }}" method="GET" class="d-inline-flex">
                    <div class="input-group w-auto">
                        <!-- Utilizando a mesma coleção de especialidades ($data) para o filtro -->
                        <select name="specialty" class="form-select" style="max-width: 250px;" required>
                            <option value="">Selecione a Especialidade</option>
                            @foreach ($data as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary" title="Pesquisar">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div><br>
            <!-- Tabela de Especialidades -->
            <div class="table-responsive">
                <table id="datatablesSimple" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th style="width: 58px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
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
                                                <a href="{{ route('admin.specialties.show', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-eye"></i> Detalhes
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.specialties.edit', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-pencil"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.specialties.destroy', $item->id) }}"
                                                    class="dropdown-item">
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
            </div>

        </div>
    </div>

@endsection
