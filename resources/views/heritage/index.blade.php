@extends('layouts.admin.layout')
@section('title', 'Todos os Patrimônios')

@section('content')
<div class="card mb-4 shadow" style="margin-top: 1.5rem;">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-building me-2"></i>Todos os Patrimônios</span>
        <div>
            <a href="{{ route('heritage.pdfAll') }}" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener noreferrer">
                <i class="fas fa-file-pdf"></i> Todos (PDF)
            </a>
            <a href="{{ route('heritage.create') }}" class="btn btn-outline-light btn-sm" title="Novo Patrimônio">
                <i class="fas fa-plus-circle"></i> Novo
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Valor (Kz)</th>
                        <th>Localização</th>
                        <th>Condição</th>
                        <th>Responsável</th>
                        <th style="width: 180px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($heritages as $h)
                    <tr>
                        <td>{{ $h->id }}</td>
                        <td>{{ Str::limit($h->Description, 40) }}</td>
                        <td>{{ $h->Type }}</td>
                        <td>{{ number_format($h->Value, 2, ',', '.') }}</td>
                        <td>{{ $h->Location }}</td>
                        <td>
                            <span class="badge bg-{{ $h->Condition == 'novo' ? 'success' : ($h->Condition == 'usado' ? 'warning' : 'danger') }}">
                                {{ ucfirst($h->Condition) }}
                            </span>
                        </td>
                        <td>{{ optional($h->responsible)->name ?? $h->FormResponsibleName }}</td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('heritage.show', $h) }}" class="btn btn-sm btn-warning" title="Ver Detalhes">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('heritage.edit', $h) }}" class="btn btn-sm btn-info" title="Editar">
                                <i class="fas fa-pencil"></i>
                            </a>
                            <a href="{{ route('heritage.maintenance.create', $h) }}" class="btn btn-sm btn-primary" title="Manutenção">
                                <i class="fas fa-tools"></i>
                            </a>
                            <a href="{{ route('heritage.transfer.create', $h) }}" class="btn btn-sm btn-success" title="Transferência">
                                <i class="fas fa-exchange-alt"></i>
                            </a>
                            <a href="{{ route('heritage.pdfSingle', $h) }}" class="btn btn-sm btn-secondary" title="PDF Individual" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <a href="#" data-url="{{ route('heritage.delete', $h) }}" class="btn btn-sm btn-danger delete-btn" title="Apagar">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Nenhum patrimônio cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $heritages->links() }}
        </div>
    </div>
</div>
@endsection