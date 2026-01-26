@extends('layouts.admin.pdf')
@section('pdfTitle', 'Ficha de Material: ' . $material->Name)
@section('titleSection')
  <h4>Ficha de Material</h4>
  <p style='text-align: center;'>
    <strong>Material:</strong> <ins>{{ $material->Name }}</ins>
  </p>
@endsection
@section('contentTable')
    <table style='font-size: 12px; width: 100%; margin-bottom: 20px;'>
        <tr><th style='width: 30%;'>Tipo</th><td>{{ $material->type->name }}</td></tr>
        <tr><th>Nº Série</th><td>{{ $material->SerialNumber }}</td></tr>
        <tr><th>Modelo</th><td>{{ $material->Model }}</td></tr>
        <tr><th>Unidade</th><td>{{ $material->Unit }}</td></tr>
        <tr><th>Stock Atual</th><td>{{ $material->CurrentStock }}</td></tr>
        <tr><th>Localização</th><td>{{ $material->Location }}</td></tr>
        <tr><th>Data de Entrada</th><td>{{ $material->EntryDate->format('d/m/Y') }}</td></tr>
        <tr><th>Fornecedor</th><td>{{ $material->SupplierName }}</td></tr>
        <tr><th>Observações</th><td>{{ $material->Notes }}</td></tr>
    </table>
    
    <h5 style='margin-top: 20px;'>Histórico de Transações</h5>
    @if($material->transactions->count())
    <table style='font-size: 10px;'>
        <thead>
            <tr>
                <th>Data</th>
                <th>Tipo</th>
                <th>Qtd</th>
                <th>Origem/Destino</th>
                <th>Responsável</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($material->transactions as $t)
                <tr>
                    <td>{{ $t->TransactionDate->format('d/m/Y') }}</td>
                    <td>{{ $t->TransactionType }}</td>
                    <td>{{ $t->Quantity }}</td>
                    <td>{{ $t->OriginOrDestination }}</td>
                    <td>{{ $t->employee->fullName ?? 'N/A' }}</td>
                    <td>{{ $t->Notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p style='text-align: center;'>Nenhuma transação registada.</p>
    @endif
@endsection
