@extends('layouts.admin.layout')
@section('title', 'Detalhes da Transação de Material')

@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-info-circle me-2"></i> <a href="{{ route('admin.infrastructures.index') }}" class="btn btn-outline-secondary  border text-white">Voltar</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-{{( $infrastructure->infrastructureMoviments->count() ?? '') == 0 ? 12 : 6}}">
                    <table class="table table-striped table-bordered mb-3">
                        <tr>
                            <th>Material</th>
                            <td>{{ $infrastructure->name }}</td>
                        </tr>
                        <tr>
                            <th>Nº Serie</th>
                            <td>{{ $infrastructure->serialNumber }}</td>
                        </tr>
                        <tr>
                            <th>MAC</th>
                            <td>{{ $infrastructure->macAddress }}</td>
                        </tr>
                        <tr>
                            <th>Modelo</th>
                            <td>{{ $infrastructure->model }}</td>
                        </tr>
                        <tr>
                            <th>Quantidade</th>
                            <td>{{ $infrastructure->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td class="text-{{ ($infrastructure->status ?? '-') == 1 ? 'success' : 'danger' }}">
                                {{ ($infrastructure->status ?? '-') == 1 ? 'Disponível' : 'Indisponível' }}</td>
                        </tr>
                        <tr>
                            <th>Data</th>
                            <td>{{ $infrastructure->id }}</td>
                        </tr>
                    </table>
                </div>
                @if ($infrastructure->infrastructureMoviments)
                    <div class="col-md-6">
                        <h3>Equipamentos transferidos</h3>
                        <table class="table table-striped table-bordered mb-3">
                            @foreach ($infrastructure->infrastructureMoviments as $item)
                                <tr>
                                <th>Destino</th>
                                <td>{{ $item->destiny ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Quantidade</th>
                                <td>{{ $item->quantity ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Responsável</th>
                                <td>{{ $item->responsible ?? 'Admin' }}</td>
                            </tr>
                            <tr>
                                <th>Documentação</th>
                                <td>
                                    @if ($item->document)
                                        <a href="{{ asset('storage/' . $infrastructure->DocumentationPath) ?? '' }}"
                                            target="_blank" class="btn btn-sm btn-info">Ver Documento</a>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                    <h5>Observações</h5>
                    <p>{{ $infrastructure->notes ?? 'Nenhuma observação.' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
