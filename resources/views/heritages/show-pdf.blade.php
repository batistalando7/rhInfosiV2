@extends('layouts.admin.pdf')
@section('pdfTitle', 'Ficha de Património: ' . $heritage->Description)
@section('titleSection')
  <h4>Ficha de Património</h4>
  <p style='text-align: center;'>
    <strong>Património:</strong> <ins>{{ $heritage->Description }}</ins>
  </p>
@endsection
@section('contentTable')
    <table style='font-size: 12px; width: 100%; margin-bottom: 20px;'>
        <tr><th style='width: 30%;'>Tipo</th><td>{{ $heritage->type->name }}</td></tr>
        <tr><th>Valor (Kz)</th><td>{{ number_format($heritage->Value, 2, ',', '.') }}</td></tr>
        <tr><th>Data de Aquisição</th><td>{{ $heritage->AcquisitionDate->format('d/m/Y') }}</td></tr>
        <tr><th>Localização Atual</th><td>{{ $heritage->Location }}</td></tr>
        <tr><th>Responsável Atual</th><td>{{ $heritage->ResponsibleName }}</td></tr>
        <tr><th>Condição</th><td>{{ $heritage->Condition }}</td></tr>
        <tr><th>Observações</th><td>{{ $heritage->Notes ?? '—' }}</td></tr>
    </table>
    
    <h5 style='margin-top: 20px;'>Histórico de Movimentação</h5>
    @php $history = $heritage->fullHistory(); @endphp
    @if($history->count())
    <table style='font-size: 10px;'>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Data</th>
                <th>Detalhes</th>
                <th>Responsável</th>
            </tr>
        </thead>
        <tbody>
            @forelse($history as $item)
                <tr>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->type == 'Manutenção' ? $item->MaintenanceDate->format('d/m/Y') : $item->TransferDate->format('d/m/Y') }}</td>
                    <td>
                        @if($item->type == 'Manutenção')
                            Custo: {{ number_format($item->MaintenanceCost, 2, ',', '.') }} Kz. Descrição: {{ $item->Description }}
                        @else
                            De: {{ $item->OriginLocation }} Para: {{ $item->DestinationLocation }}. Motivo: {{ $item->Reason }}
                        @endif
                    </td>
                    <td>{{ $item->ResponsibleName }}</td>
                </tr>
            @empty
                <tr><td colspan='4' style='text-align: center;'>Nenhum histórico de movimentação registado.</td></tr>
            @endforelse
        </tbody>
    </table>
    @else
        <p style='text-align: center;'>Nenhum histórico de movimentação registado.</p>
    @endif
@endsection
