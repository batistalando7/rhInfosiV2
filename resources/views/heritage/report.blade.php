<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Patrimônio</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h5 { margin-top: 20px; }
    </style>
</head>
<body>
    <h4>Relatório Completo de Patrimônio</h4>
    <p>Total de Itens: {{ $heritages->count() }}</p>

    @foreach($heritages as $h)
        <h5>{{ $h->Description }} ({{ $h->Type }})</h5>
        <table>
            <tr><th>Valor</th><td>{{ number_format($h->Value, 2) }} AKZ</td></tr>
            <tr><th>Data de Aquisição</th><td>{{ $h->AcquisitionDate->format('d/m/Y') }}</td></tr>
            <tr><th>Localização</th><td>{{ $h->Location }}</td></tr>
            <tr><th>Condição</th><td>{{ ucfirst($h->Condition) }}</td></tr>
            <tr><th>Responsável pelo Formulário</th><td>{{ $h->FormResponsibleName }} - {{ $h->FormResponsibleEmail }} ({{ $h->FormDate->format('d/m/Y') }})</td></tr>
        </table>

        @if($h->maintenances->count() > 0)
            <h6>Histórico de Manutenção</h6>
            <table>
                <tr><th>Data</th><th>Descrição</th><th>Responsável</th></tr>
                @foreach($h->maintenances as $m)
                    <tr><td>{{ $m->MaintenanceDate->format('d/m/Y') }}</td><td>{{ $m->MaintenanceDescription }}</td><td>{{ $m->MaintenanceResponsible }}</td></tr>
                @endforeach
            </table>
        @endif

        @if($h->transfers->count() > 0)
            <h6>Transferências</h6>
            <table>
                <tr><th>Data</th><th>Motivo</th><th>Responsável</th></tr>
                @foreach($h->transfers as $t)
                    <tr><td>{{ $t->TransferDate->format('d/m/Y') }}</td><td>{{ $t->TransferReason }}</td><td>{{ $t->TransferResponsible }}</td></tr>
                @endforeach
            </table>
        @endif
    @endforeach
</body>
</html>