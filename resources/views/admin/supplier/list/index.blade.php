@extends('layouts.admin.layout')
@section('title', 'Materiais')

@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-tools me-2"></i> Materiais de Infraestrutura</span>
            <a href="{{ route('admin.suppliers.create') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-plus-circle me-1"></i> Novo Material
            </a>
        </div>
        <div class="card-body">
            @if (session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>NIF</th>
                        <th>Endereço</th>
                        <th>Email</th>
                        <th>Site</th>
                        <th style="width: 100px;" class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->nif }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->site }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Operações
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('admin.suppliers.show', $item->id) }}"
                                                class="dropdown-item">
                                                <i class="fas fa-eye"></i> Detalhes
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.suppliers.edit', $item->id) }}"
                                                class="dropdown-item">
                                                <i class="fas fa-pencil"></i>Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.suppliers.destroy', $item->id) }}"
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
                            <td colspan="6" class="text-center">Nenhum material cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
