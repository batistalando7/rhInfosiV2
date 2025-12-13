@extends('layouts.admin.pdf')
@section('pdfTitle', 'Relatório de Saídas de Património')

@section('content')
    <h4 class='text-center mb-4'>Relatório de Saídas de Património</h4>
    <table class='table table-bordered table-striped'>
        <thead>
            <tr>
                <th>Património</th>
                <th>Tipo</th>
                <th>Data</th>
                <th>Qtde</th>
                <th>Destino</th>
                <th>Departamento</th>
                <th>Responsável</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($txs as $t)
                <tr>
                    <td>{{ $t->heritage->Name }}</td>
                    <td>{{ $t->heritage->type->name }}</td>
                    <td>{{ $t->TransactionDate->format('d/m/Y') }}</td>
                    <td>{{ $t->Quantity }}</td>
                    <td>{{ $t->OriginOrDestination }}</td>
                    <td>{{ $t->department->name ?? 'N/A' }}</td>
                    <td>{{ $t->creator->fullName ?? 'Admin' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
