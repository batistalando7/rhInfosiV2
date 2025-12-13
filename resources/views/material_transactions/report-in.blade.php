@extends('layouts.admin.pdf')
@section('pdfTitle', 'Relatório de Entrada de Material')
@section("titleSection")
  <h4>Relatório de Entrada de Material</h4>
  <p style="text-align: center;">
    <strong>Total de Entradas:</strong> <ins>{{ $transactions->count() }}</ins>
  </p>
@endsection
@section('contentTable')
  @if($transactions->count())
    <table style="font-size: 10px;">
      <thead>
        <tr>
          <th>Data</th>
          <th>Material</th>
          <th>Qtd</th>
          <th>Unidade</th>
          <th>Origem</th>
          <th>Responsável</th>
          <th>Observação</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($transactions as $t)
          <tr>
            <td>{{ $t->TransactionDate->format('d/m/Y') }}</td>
            <td>{{ $t->material->Name }}</td>
            <td>{{ $t->Quantity }}</td>
            <td>{{ $t->material->Unit }}</td>
            <td>{{ $t->OriginOrDestination }}</td>
            <td>{{ $t->employee->fullName ?? 'N/A' }}</td>
            <td>{{ $t->Notes }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style="text-align: center;">Nenhuma transação de entrada encontrada.</p>
  @endif
@endsection
