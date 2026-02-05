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
                        <th>Categoria</th>
                        <th>Fornecedor</th>
                        {{-- <th>MAC</th> --}}
                        <th>Modelo</th>
                        <th>Quantidade</th>
                        <th>Data de fabríco</th>
                        <th style="width: 100px;" class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($heritages as $item)
                        <tr>
                            <td>{{ $item->name ?? '-' }}</td>
                            <td>{{ $item->heritageType->name ?? '-' }}</td>
                            <td>{{ $item->supplier->name ?? '-' }}</td>
                            {{-- <td>{{ $item->macAddress ?? '-' }}</td> --}}
                            <td>{{ $item->model ?? '-' }}</td>
                            <td>{{ $item->quantity ?? '-' }}</td>
                            <td>{{ $item->manufactureDate ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Operações
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('admin.heritages.show', $item->id) }}" class="dropdown-item">
                                                <i class="fas fa-eye"></i> Detalhes
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.heritages.edit', $item->id) }}" class="dropdown-item">
                                                <i class="fas fa-pencil"></i>Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.heritages.destroy', $item->id) }}"
                                                class="dropdown-item">
                                                <i class="fas fa-trash"></i>Deletar
                                            </a>
                                        </li>
                                        {{-- <li>
                                            <a href="#" data-url="{{ route('admin.heritageTypes.destroy', $t->id) }}" class="dropdown-item"
                                                 title="Remover"><i
                                                    class="fas fa-trash"></i></a>Deletar
                                        </li> --}}
                                    </ul>
                                </div>
                                {{-- <a href="{{ route('admin.infrastructures.show', $item->id) }}" class="btn btn-sm btn-info"
                                    title="Ver"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.infrastructures.edit', $item->id) }}" class="btn btn-sm btn-warning"
                                    title="Editar"><i class="fas fa-pencil"></i></a>
                                <a href="#" data-url="{{ route('admin.infrastructures.destroy', $item->id) }}"
                                    class="btn btn-sm btn-danger delete-btn" title="Remover"><i class="fas fa-trash"></i></a> --}}
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
