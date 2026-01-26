<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Histórico do Funcionário</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2, h3, h4 {
            margin-bottom: 5px;
        }

        .header {
            border-bottom: 2px solid #444;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }

        .employee-info {
            margin-bottom: 20px;
        }

        .employee-info p {
            margin: 3px 0;
        }

        .photo {
            float: right;
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table th, table td {
            border: 1px solid #aaa;
            padding: 6px;
            text-align: left;
        }

        table th {
            background-color: #f0f0f0;
        }

        ul {
            padding-left: 15px;
        }

        li {
            margin-bottom: 5px;
        }

        .section {
            margin-top: 20px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Histórico do Funcionário</h2>
    <strong>{{ $employee->fullName }}</strong>
</div>

@if($employee->photo)
    <img src="{{ public_path('frontend/images/departments/' . $employee->photo) }}" class="photo">
@endif

<div class="employee-info">
    <p><strong>Departamento Atual:</strong> {{ $employee->department->title ?? '-' }}</p>
    <p><strong>Vínculo:</strong> {{ $employee->employeeType->name ?? '-' }}</p>
    <p><strong>E-mail:</strong> {{ $employee->email }}</p>
    <p><strong>Nacionalidade:</strong> {{ $employee->nationality }}</p>
    <p><strong>Data de Ingresso:</strong> {{ \Carbon\Carbon::parse($employee->entry_date)->format('d/m/Y') }}</p>
</div>

<div class="section">
    <h4>Histórico de Cargos</h4>
    <ul>
        <li>
            {{ \Carbon\Carbon::parse($employee->created_at)->format('d/m/Y') }}
            — <strong>{{ $employee->position->name ?? 'Funcionário' }}</strong>
        </li>
    </ul>
</div>

<div class="section">
    <h4>Mobilidades</h4>
    <ul>
        @forelse($employee->mobilities as $m)
            <li>
                {{ \Carbon\Carbon::parse($m->created_at)->format('d/m/Y') }}
                — {{ $m->oldDepartment->title }} → {{ $m->newDepartment->title }}<br>
                <small>Motivo: {{ $m->causeOfMobility }}</small>
            </li>
        @empty
            <li>Nenhuma mobilidade registrada.</li>
        @endforelse
    </ul>
</div>

<div class="section">
    <h4>Destacamentos</h4>
    <ul>
        @forelse($employee->secondments as $s)
            <li>
                {{ \Carbon\Carbon::parse($s->created_at)->format('d/m/Y') }}
                — {{ $s->institution }}<br>
                <small>Motivo: {{ $s->causeOfTransfer }}</small>
            </li>
        @empty
            <li>Nenhum destacamento registrado.</li>
        @endforelse
    </ul>
</div>

<div class="section">
    <h4>Trabalhos Extras</h4>
    <ul>
        @forelse($employee->extraJobs as $j)
            <li>
                {{ $j->title }} ({{ \Carbon\Carbon::parse($j->created_at)->format('d/m/Y') }})<br>
                <small>Recebeu: {{ number_format($j->pivot->assignedValue,2,',','.') }} Kz</small>
            </li>
        @empty
            <li>Nenhum trabalho extra registrado.</li>
        @endforelse
    </ul>
</div>

<div class="section">
    <h4>Pagamentos de Salário</h4>
    <table>
        <thead>
        <tr>
            <th>Competência</th>
            <th>Bruto</th>
            <th>Desconto</th>
            <th>Líquido</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @forelse($employee->salaryPayments as $p)
            <tr>
                <td>{{ \Carbon\Carbon::parse($p->workMonth)->translatedFormat('F/Y') }}</td>
                <td>{{ number_format($p->baseSalary + $p->subsidies,2,',','.') }}</td>
                <td>{{ number_format($p->discount,2,',','.') }}</td>
                <td>{{ number_format($p->salaryAmount,2,',','.') }}</td>
                <td>{{ __('status.' . strtolower($p->paymentStatus)) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center">Nenhum pagamento registrado.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="footer">
    Documento gerado em {{ now()->format('d/m/Y H:i') }}
</div>

</body>
</html>
