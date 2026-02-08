@extends('layouts.admin.layout')
@section('title', 'Administradores')
@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-person-lines-fill me-2"></i>Lista de Administradores</span>
            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Novo">
                <i class="fas fa-plus-circle"></i>
            </a>
        </div>
        <div class="card-body">
            <!-- Formulário de pesquisa -->
            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
                <div class="input-group" style="max-width: 400px;">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nome do funcionário"
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Funcionário Vinculado</th>
                            <th>Papel</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->employee->fullName ?? 'Não vinculado' }}</td>
                                <td>
                                    @switch($item->role)
                                        @case('admin')
                                            Administrador
                                        @break

                                        @case('director')
                                            Diretor
                                        @break

                                        @case('department_head')
                                            Chefe de Departamento
                                        @break

                                        @case('employee')
                                            Funcionário
                                        @break

                                        @case('hr')
                                            Área Administrativa (RH)
                                        @break

                                        @default
                                            {{ ucfirst($item->role) }}
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Operações
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('admin.users.show', $item->id) }}" class="dropdown-item">
                                                    <i class="fas fa-eye"></i> Detalhes
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.users.edit', $item->id) }}" class="dropdown-item">
                                                    <i class="fas fa-pencil"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                {{-- <a href="{{ route('admin.users.destroy', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-trash"></i>Deletar
                                                </a> --}}
                                                <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class=" dropdown-item" title="Apagar"
                                                        onclick="return confirm('Tem certeza?')">
                                                        <i class="fas fa-trash"></i>Deletar
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    @if ($item->role == 'employee')
                                        <a href="{{ route('admin.users.contract', $item->id) }}"
                                            class="btn btn-success btn-sm" style="width: 40px" title="Gerar Contrato">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
