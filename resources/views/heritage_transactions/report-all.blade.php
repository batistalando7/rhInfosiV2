@extends('layouts.admin.pdf')
@section('title', 'Histórico Total de Património')

@section('content')
    <h4 class='text-center mb-4'>Histórico Total de Património</h4>
    <table class='table table-bordered table-striped'>
        <thead>
            <tr>
                <th>Tipo Trans.</th>
                <th>Património</th>
                <th>Tipo</th>
                <th>Data</th>
                <th>Qtde</th>
                <th>Origem/Destino</th>
                <th>Responsável</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($txs as $t)
                <tr>
                    <td>{{ $t->TransactionType == 'in' ? 'Entrada' : 'Saída' }}</td>
                    <td>{{ $t->heritage->Name }}</td>
                    <td>{{ $t->heritage->type->name }}</td>
                    <td>{{ $t->TransactionDate->format('d/m/Y') }}</td>
                    <td>{{ $t->Quantity }}</td>
                    <td>{{ $t->OriginOrDestination }}</td>
                    <td>{{ $t->creator->fullName ?? 'Admin' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
