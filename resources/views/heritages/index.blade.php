@extends('layouts.admin.layout')
@section('title', 'Património')

@section('content')
    <div class="card mb-4 shadow">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-building me-2"></i> Controlo de Património</span>
    <div>
        <a href="{{ route('heritages.create') }}" class="btn btn-outline-light btn-sm me-2">
            <i class="fas fa-plus-circle me-1"></i> Novo Património
        </a>
        <a href="{{ route('heritages.report-all') }}" target="_blank" class="btn btn-outline-light btn-sm">
            <i class="fas fa-file-pdf me-2"></i> Relatório Total
        </a>
    </div>
</div>
        <div class="card-body">
            @if (session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Localização</th>
                        <th>Responsável</th>
                        <th>Condição</th>
                        <th>Valor (Kz)</th>
                        <th style="width: 200px;" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody> 
    @forelse($heritages as $h)
        <tr>
            <td>{{ $h->Description }}</td>
            <td>{{ $h->type->name }}</td>
            <td>{{ $h->Location }}</td>
            <td>{{ $h->ResponsibleName }}</td>
            <td>
                <span class="badge bg-{{ $h->Condition == 'Novo' ? 'success' : ($h->Condition == 'Danificado' || $h->Condition == 'Avariado' ? 'danger' : 'warning') }}">
                    {{ $h->Condition }}
                </span>
            </td>
            <td>{{ number_format($h->Value, 2, ',', '.') }} Kz</td>
            <td class="text-center align-middle"> <!-- align-middle aqui garante alinhamento perfeito -->
                <a href="{{ route('heritages.show', $h->id) }}" class="btn btn-sm btn-info px-2 py-1 mx-1" title="Ver">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('heritages.maintenance', $h->id) }}" class="btn btn-sm btn-primary px-2 py-1 mx-1" title="Manutenção">
                    <i class="fas fa-wrench"></i>
                </a>
                <a href="{{ route('heritages.transfer', $h->id) }}" class="btn btn-sm btn-success px-2 py-1 mx-1" title="Transferir">
                    <i class="fas fa-exchange-alt"></i>
                </a>
                <a href="{{ route('heritages.edit', $h->id) }}" class="btn btn-sm btn-warning px-2 py-1 mx-1" title="Editar">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a href="#" data-url="{{ route('heritages.destroy', $h->id) }}"
                   class="btn btn-sm btn-danger px-2 py-1 mx-1 delete-btn" title="Apagar">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">Nenhum património cadastrado.</td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>
    </div>
@endsection
