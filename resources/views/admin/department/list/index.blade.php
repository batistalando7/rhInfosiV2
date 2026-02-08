@extends('layouts.admin.layout')
@section('title', 'Departments (Departamentos)')
@section('content')

    <div class="card mb-4 mt-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-building me-2"></i>Lista de Departamentos</span>
            <a href="{{ route('admin.department.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Novo"> Novo
                <i class="fas fa-plus-circle"></i>
            </a>
        </div>
        <div class="card-body">

            <!-- Formulário para selecionar departamento e listar seus funcionários -->
            <div class="mt-4">
                <p class="mb-3  text-muted">Listar funcionários por departamento:</p>
                <form action="{{ route('admin.department.employeee') }}" method="GET" class="d-inline-flex">
                    <div class="input-group w-auto">
                        <select name="department" class="form-select" style="max-width: 300px;" required>
                            <option value=""> Selecione o Departamento </option>
                            @foreach ($data as $d)
                                <option value="{{ $d->id }}">{{ $d->title }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary" title="Pesquisar">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div><br>

            <div class="table-responsive">
                <table id="datatablesSimple" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th style="width: 58px;">Ação</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($data)
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->description ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Operações
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('admin.department.show', $item->id) }}"
                                                        class="dropdown-item">
                                                        <i class="fas fa-eye"></i> Detalhes
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.department.edit', $item->id) }}"
                                                        class="dropdown-item">
                                                        <i class="fas fa-pencil"></i>Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.department.destroy', $item->id) }}"
                                                        class="dropdown-item">
                                                        <i class="fas fa-trash"></i>Deletar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
