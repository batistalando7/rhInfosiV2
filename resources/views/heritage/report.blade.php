@extends('layouts.admin.pdf')

@section('pdfTitle', 'Relatório de Patrimônio')

@section('titleSection')
  <h4>Relatório Completo de Patrimônio</h4>
  <p>Total: {{ $heritages->count() }} itens</p>
@endsection

@section('contentTable')
  @if($heritages->count())
    <table>
      <thead>
        <tr>
          <th>Descrição</th>
          <th>Tipo</th>
          <th>Valor</th>
          <th>Condição</th>
          <th>Localização</th>
          <th>Data de Aquisição</th>
        </tr>
      </thead>
      <tbody>
        @foreach($heritages as $h)
        <tr>
          <td>{{ $h->Description }}</td>
          <td>{{ $h->Type }}</td>
          <td>{{ $h->Value }}</td>
          <td>{{ ucfirst($h->Condition) }}</td>
          <td>{{ $h->Location }}</td>
          <td>{{ $h->AcquisitionDate->format('d/m/Y') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p>Nenhum patrimônio.</p>
  @endif
@endsection