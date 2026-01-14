@extends('layouts.admin.layout')

@section('title', 'Funcionários')

@section('content')
<div class="card mb-4 p-4 rounded shadow-sm">

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
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               class="form-control form-control-sm rounded-start"
               placeholder="Pesquisar funcionário">
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
            @forelse($data as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->fullName }}</td>
                    <td>{{ $d->department->title ?? '-' }}</td>
                    <td>{{ $d->position->name ?? '-' }}</td>
                    <td>{{ $d->specialty->name ?? '-' }}</td>
                    <td>{{ $d->employeeType->name ?? '-' }}</td>
                    <td>{{ $d->employeeCategory->name ?? '-' }}</td>
                    <td>{{ $d->academicLevel ?? '-' }}</td>
                    <td>{{ $d->course->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.employeee.show',$d->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.employeee.edit',$d->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="#" data-url="{{ url('employeee/'.$d->id.'/delete') }}"
                           class="btn btn-danger btn-sm delete-btn">
                            <i class="fas fa-trash"></i>
                        </a>
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
