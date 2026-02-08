@extends('layouts.admin.layout')
@section('title', 'Histórico de ' . $employee->fullName)
@section('content')
<div class="card mt-4">
  <div class="card-header bg-secondary">
    <h3 class="text-light fw-bold">Histórico do Funcionário</h3>
      <a href="{{ route('admin.employeee.history.pdf', $employee->id) }}" target="_blank" class="btn btn-outline-light">Baixar PDF</a>
  </div>
  <div class="card-body">
    <div class="row mb-4">
      <div class="col-md-4 text-center">
        <img src="{{ asset('frontend/images/departments/' . $employee->photo) }}"
             class="img-fluid rounded-circle shadow" alt="Foto">
      </div>
      <div class="col-md-8 m-auto border p-3 px-4 rounded shadow-sm">
        <p><strong>Departamento Atual:</strong> {{ $employee->department->title ?? '-' }}</p>
        <p><strong>Vínculo de Funcionário:</strong> {{ $employee->employeeType->name ?? '-' }}</p>
        <p><strong>E-mail:</strong> {{ $employee->email }}</p>
        <p><strong>Nacionalidade:</strong> {{ $employee->nationality }}</p>
        <p><strong>Data de Ingresso:</strong> {{ \Carbon\Carbon::parse($employee->entry_date)->format('d/m/Y') }}</p>
      </div>
    </div>

    {{-- Seções cronológicas --}}
    {{-- <h4>Histórico de Cargos</h4>
    <ul class="list-group mb-4">
      @if(isset($employee->positionHistories))

      @foreach($employee->positionHistories as $h)
      <li class="list-group-item">
        {{ \Carbon\Carbon::parse($h->startDate)->format('d/m/Y') }}
        @if($h->endDate)
          até {{ \Carbon\Carbon::parse($h->endDate)->format('d/m/Y') }}
        @else
          até atualmente
        @endif
        — <strong>{{ $h->position->name }}</strong>
      </li>
      @endforeach
      @endif
    </ul> --}}
    <h4>Histórico de Cargos</h4>
    <ul class="list-group mb-4">
      <li class="list-group-item">
        {{ \Carbon\Carbon::parse($employee->created_at)->format('d/m/Y') }}
        — <strong>{{ $employee->position->name ?? 'Funcionário' }}</strong>
      </li>
    </ul>

    <h4>Mobilidades</h4>
    <ul class="list-group mb-4">
      @forelse($employee->mobilities as $m)
      <li class="list-group-item">
        {{ \Carbon\Carbon::parse($m->created_at)->format('d/m/Y') }}
        — Transferido: <em>{{ $m->oldDepartment->title }} → {{ $m->newDepartment->title }}</em>
        <br><small>Motivo: {{ $m->causeOfMobility }}</small>
      </li>
      @empty
      <li class="list-group-item">Nenhuma mobilidade registrada.</li>
      @endforelse
    </ul>

    <h4>Destacamentos</h4>
    <ul class="list-group mb-4">
      @forelse($employee->secondments as $s)
      <li class="list-group-item">
        {{ \Carbon\Carbon::parse($s->created_at)->format('d/m/Y') }}
        — Destaque para <strong>{{ $s->institution }}</strong>
        <br><small>Motivo: {{ $s->causeOfTransfer }}</small>
      </li>
      @empty
      <li class="list-group-item">Nenhum destacamento registrado.</li>
      @endforelse
    </ul>

    <h4>Trabalhos Extras</h4>
    <ul class="list-group mb-4">
      @forelse($employee->extraJobs as $j)
      <li class="list-group-item">
        {{ $j->title }} ({{ \Carbon\Carbon::parse($j->created_at)->format('d/m/Y') }})
        <br><small>Recebeu: {{ number_format($j->pivot->assignedValue,2,',','.') }} Kz</small>
      </li>
      @empty
      <li class="list-group-item">Nenhum trabalho extra registrado.</li>
      @endforelse
    </ul>

    <h4>Pagamentos de Salário</h4>
    <table class="table table-striped">
      <thead>
        <tr><th>Competência</th><th>Bruto</th><th>Desconto</th><th>Líquido</th><th>Status</th></tr>
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
          <td colspan="5" class="text-center">Nenhum pagamento de salário registrado.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection