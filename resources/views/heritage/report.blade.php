<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Patrimônio</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>RELATÓRIO DE PATRIMÔNIO</h1>
        <p>Gerado em: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    @foreach($heritages as $h)
    <h3>{{ $h->Description }} ({{ $h->Type }})</h3>
    <p><strong>Valor:</strong> {{ number_format($h->Value, 2) }} Kz | 
       <strong>Aquisição:</strong> {{ $h->AcquisitionDate->format('d/m/Y') }} | 
       <strong>Local:</strong> {{ $h->Location }}</p>
    <p><strong>Responsável:</strong> {{ $h->responsible?->name ?? $h->FormResponsibleName }}</p>
    <hr>
    @endforeach
</body>
</html>