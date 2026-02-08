@extends('layouts.admin.layout')

@section('title', 'Funcionários')

@section('content')
    <div class="card mt-4 p-4 rounded shadow-sm">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="fas fa-users me-2"></i>Todos os Funcionários</h4>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.employeee.pdfAll') }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
                <a href="{{ route('admin.employeee.filter') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-calendar-alt"></i> Filtrar
                </a>
                <a href="{{ route('admin.employeee.create') }}" class="btn btn-outline-secondary btn-sm">
                    Novo <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>

        {{-- SEARCH --}}
        <form method="GET" class="d-flex mb-3" style="max-width:320px">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-control form-control-sm rounded-start" placeholder="Pesquisar funcionário">
            <button class="btn btn-outline-primary btn-sm rounded-end">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome Completo</th>
                        <th>Departamento</th>
                        <th>Cargo</th>
                        <th>Especialidade</th>
                        <th>Tipo</th>
                        <th>Categoria</th>
                        <th>Nível Acadêmico</th>
                        <th>Curso</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->fullName }}</td>
                            <td>{{ $item->department->title ?? '-' }}</td>
                            <td>{{ $item->position->name ?? '-' }}</td>
                            <td>{{ $item->specialty->name ?? '-' }}</td>
                            <td>{{ $item->employeeType->name ?? '-' }}</td>
                            <td>{{ $item->employeeCategory->name ?? '-' }}</td>
                            <td>{{ $item->academicLevel ?? '-' }}</td>
                            <td>{{ $item->course->name ?? '-' }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Operações
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('admin.employeee.show', $item->id) }}"
                                                class="dropdown-item">
                                                <i class="fas fa-eye"></i> Detalhes
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.employeee.edit', $item->id) }}"
                                                class="dropdown-item">
                                                <i class="fas fa-pencil"></i>Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.employeee.destroy', $item->id) }}"
                                                class="dropdown-item">
                                                <i class="fas fa-trash"></i>Deletar
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Nenhum funcionário encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
