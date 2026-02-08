@extends('layouts.admin.layout')
@section('title', 'Estagiários')
@section('content')

    <div class="card mt-4 shadow">

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
                            {{-- <th>Especialidade</th> --}}
                            <th>Endereço</th>
                            <th>Email</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->fullName }}</td>
                                <td>{{ $item->department->title ?? '-' }}</td>
                                {{-- <td>{{ $item->specialty->name ?? '-' }}</td> --}}
                                <td>{{ $item->address ?? '-' }}</td>
                                <td>{{ $item->email ?? '-' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Operações
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('admin.intern.show', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-eye"></i> Detalhes
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.intern.edit', $item->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fas fa-pencil"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.intern.destroy', $item->id) }}"
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
                                <td colspan="7" class="text-center">Nenhum estagiário encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
