@extends('layouts.admin.layout')
@section('title', 'Materiais')

@section('content')
    <div class="card mb-4 shadow">
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
                                <a href="{{ route('admin.suppliers.show', $item->id) }}" class="btn btn-sm btn-info"
                                    title="Ver"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.suppliers.edit', $item->id) }}" class="btn btn-sm btn-warning"
                                    title="Editar"><i class="fas fa-pencil"></i></a>
                                <a href="#" data-url="{{ route('admin.suppliers.destroy', $item->id) }}"
                                    class="btn btn-sm btn-danger delete-btn" title="Remover"><i class="fas fa-trash"></i></a>
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
