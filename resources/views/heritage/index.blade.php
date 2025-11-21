@extends('layouts.admin.layout')
@section('title', 'Todos os Patrimônios')

@section('content')
<div class="card mb-4 shadow" style="margin-top: 1.5rem;">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span> Todos os Patrimônios</span>
        <div class="d-flex gap-2">
            <a href="{{ route('heritage.pdfAll') }}" class="btn btn-outline-light btn-sm" style="width:110px;" target="_blank">
                PDF Todos
            </a>
            <a href="{{ route('heritage.create') }}" class="btn btn-outline-light btn-sm" style="width:110px;">
                Novo
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Valor (Kz)</th>
                        <th>Localização</th>
                        <th>Condição</th>
                        <th>Responsável</th>
                        <th class="text-center" style="width: 180px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($heritages as $h)
                    <tr>
                        <td>{{ $h->id }}</td>
                        <td>{{ Str::limit($h->Description, 40) }}</td>
                        <td>{{ $h->Type }}</td>
                        <td class="text-end">{{ number_format($h->Value, 2, ',', '.') }}</td>
                        <td>{{ $h->Location }}</td>
                        <td>
                            <span class="badge bg-{{ $h->Condition == 'novo' ? 'success' : ($h->Condition == 'usado' ? 'warning' : 'danger') }}">
                                {{ ucfirst($h->Condition) }}
                            </span>
                        </td>
                        <td>{{ optional($h->responsible)->name ?? $h->FormResponsibleName }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('heritage.show', $h) }}" class="btn btn-warning" title="Ver">
                                </a>
                                <a href="{{ route('heritage.edit', $h) }}" class="btn btn-info" title="Editar">
                                </a>
                                <a href="{{ route('heritage.maintenance.create', $h) }}" class="btn btn-primary" title="Manutenção">
                                </a>
                                <a href="{{ route('heritage.transfer.create', $h) }}" class="btn btn-success" title="Transferir">
                                </a>
                                <a href="{{ route('heritage.pdfSingle', $h) }}" class="btn btn-secondary" title="PDF" target="_blank">
                                </a>
                                <a href="#" data-url="{{ route('heritage.delete', $h) }}" class="btn btn-danger delete-btn" title="Apagar">
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Nenhum patrimônio cadastrado.</td></tr>
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