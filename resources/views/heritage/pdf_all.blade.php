@extends('layouts.admin.pdf')

@section('pdfTitle', 'Relatório Completo de Patrimônio')

@section('titleSection')
    <h4 class="text-center">RELATÓRIO COMPLETO DE PATRIMÔNIO</h4>
    <p class="text-center text-muted">
        Gerado em: {{ now()->format('d/m/Y \à\s H:i') }}
        &nbsp;|&nbsp;
        Total de Itens: <strong>{{ $heritages->count() }}</strong>
        &nbsp;|&nbsp;
        Valor Total: <strong>{{ number_format($heritages->sum('Value'), 2, ',', '.') }} Kz</strong>
    </p>
@endsection

@section('contentTable')
    @if($heritages->count())
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Tipo</th>
                    <th>Valor (Kz)</th>
                    <th>Aquisição</th>
                    <th>Localização</th>
                    <th>Condição</th>
                    <th>Responsável</th>
                </tr>
            </thead>
            <tbody>
                @foreach($heritages as $h)
                <tr>
                    <td>{{ $h->id }}</td>
                    <td>{{ $h->Description }}</td>
                    <td>{{ $h->Type }}</td>
                    <td>{{ number_format($h->Value, 2, ',', '.') }}</td>
                    <td>{{ $h->AcquisitionDate->format('d/m/Y') }}</td>
                    <td>{{ $h->Location }}</td>
                    <td>
                        @if($h->Condition == 'novo')
                            <strong class="text-success">Novo</strong>
                        @elseif($h->Condition == 'usado')
                            <strong class="text-warning">Usado</strong>
                        @else
                            <strong class="text-danger">Danificado</strong>
                        @endif
                    </td>
                    <td>{{ optional($h->responsible)->name ?? $h->FormResponsibleName ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center">Nenhum patrimônio cadastrado.</p>
    @endif
@endsection