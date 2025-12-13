@extends('layouts.admin.pdf')
@section('pdfTitle', 'Relatório Total de Património')
@section('titleSection')
  <h4>Relatório Total de Património</h4>
  <p style='text-align: center;'>
    <strong>Total de Patrimónios:</strong> <ins>{{ $heritages->count() }}</ins>
  </p>
@endsection
@section('contentTable')
  @if($heritages->count())
    <table style='font-size: 10px;'>
      <thead>
        <tr>
          <th>Descrição</th>
          <th>Tipo</th>
          <th>Valor (Kz)</th>
          <th>Aquisição</th>
          <th>Localização</th>
          <th>Responsável</th>
          <th>Condição</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($heritages as $h)
          <tr>
            <td>{{ $h->Description }}</td>
            <td>{{ $h->type->name }}</td>
            <td>{{ number_format($h->Value, 2, ',', '.') }}</td>
            <td>{{ $h->AcquisitionDate->format('d/m/Y') }}</td>
            <td>{{ $h->Location }}</td>
            <td>{{ $h->ResponsibleName }}</td>
            <td>{{ $h->Condition }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style='text-align: center;'>Nenhum património cadastrado.</p>
  @endif
@endsection
