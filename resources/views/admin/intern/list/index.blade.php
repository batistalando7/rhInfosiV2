@extends('layouts.admin.layout')
@section('title', 'Estagiários')
@section('content')

    <div class="card mb-4 shadow">

        {{-- <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-person-lines-fill me-2"></i>Todos os Estagiários</span>
    <div>
      <a href="{{ route('admin.intern.pdfAll') }}" class="btn btn-outline-light btn-sm" target="_blank">
        <i class="fas fa-file-earmark-pdf"></i> PDF
      </a>
      <a href="{{ route('admin.intern.create') }}" class="btn btn-outline-light btn-sm">
        Novo <i class="fas fa-plus-circle"></i>
      </a>
    </div>
  </div> --}}
        <div class=" card-header d-flex justify-content-between align-items-center mb-3 mt-3">
            <h4><i class="fas fa-users me-2"></i>Todos os Estagiários</h4>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.intern.pdfAll') }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                    <i class="fas fa-file-earmark-pdf"></i> PDF
                </a>
                <a href="{{ route('admin.intern.filter') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-calendar-alt"></i> Filtrar
                </a>
                <a href="{{ route('admin.intern.create') }}" class="btn btn-outline-secondary btn-sm">
                    Novo <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>

        <div class="card-body">

            {{-- SEARCH --}}
            <form method="GET" class="d-flex mb-3" style="max-width:320px">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control form-control-sm rounded-start" placeholder="Pesquisar estagiário">
                <button class="btn btn-outline-primary btn-sm rounded-end">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Departamento</th>
                            <th>Especialidade</th>
                            <th>Endereço</th>
                            <th>Email</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $d)
                            <tr>
                                <td>{{ $d->id }}</td>
                                <td>{{ $d->fullName }}</td>
                                <td>{{ $d->department->title ?? '-' }}</td>
                                <td>{{ $d->specialty->name ?? '-' }}</td>
                                <td>{{ $d->address ?? '-' }}</td>
                                <td>{{ $d->email ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.intern.show', $d->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.intern.edit', $d->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-pencil"></i>
                                    </a>
                                    <a href="#" data-url="{{ route('admin.intern.destroy', $d->id) }}"
                                        class="btn btn-danger btn-sm delete-btn">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Nenhum estagiário encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
