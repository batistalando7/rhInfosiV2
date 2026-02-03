@extends('layouts.admin.layout')
@section('title', 'Materiais')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-tools me-2"></i> Materiais de Infraestrutura</span>
            <a href="{{ route('admin.infrastructures.create') }}" class="btn btn-outline-light btn-sm">
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
                        <th>Tipo</th>
                        <th>Nº Série</th>
                        <th>MAC</th>
                        <th>Modelo</th>
                        <th>Quantidade</th>
                        <th>Estado</th>
                        <th style="width: 100px;" class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($infrastructures as $item)
                        <tr>
                            <td>{{ $item->name ?? '-' }}</td>
                            <td>{{ $item->id ?? '-' }}</td>
                            <td>{{ $item->serialNumber ?? '-' }}</td>
                            <td>{{ $item->macAddress ?? '-' }}</td>
                            <td>{{ $item->model ?? '-' }}</td>
                            <td>{{ $item->quantity ?? '-' }}</td>
                            <td class="text-{{($item->status ?? '-') == 1 ? 'success':'danger'}}">{{ ($item->status ?? '-') == 1 ? 'Disponível':'Indisponível' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.infrastructures.show', $item->id) }}" class="btn btn-sm btn-info"
                                    title="Ver"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.infrastructures.edit', $item->id) }}" class="btn btn-sm btn-warning"
                                    title="Editar"><i class="fas fa-pencil"></i></a>
                                <a href="#" data-url="{{ route('admin.infrastructures.destroy', $item->id) }}"
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
