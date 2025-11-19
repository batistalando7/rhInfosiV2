@extends('layouts.admin.layout')
@section('title','Detalhes do Pagamento')

@section('content')

<div class="container my-5">

  {{-- Cabeçalho com botão de voltar --}}
  <div class="row mb-4">
    <div class="col-8">
      <h3><i class="fas fa-eye me-2"></i>Detalhes do Pagamento</h3>
    </div>
    <div class="col-4 text-end">
      <a href="{{ route('salaryPayment.index') }}"
         class="btn btn-outline-secondary btn-sm" style="width: 90px;">
        <i class="fas fa-arrow-left"></i> Voltar
      </a>
    </div>
  </div>

  {{-- Card com informações gerais --}}
  <div class="row justify-content-center mb-4">
    <div class="col-lg-8">
      <div class="card shadow-sm">

        <div class="card-header bg-secondary text-white text-center">
          <strong>Informações do Pagamento</strong>
        </div>

        <div class="card-body px-4">

          <h4 class="text-center mb-3">
            Funcionário: {{ $salaryPayment->employee->fullName }}
          </h4>

          <table class="table table-striped table-bordered">
            <tbody>

              <tr>
                <th>Competência</th>
                <td>{{ \Carbon\Carbon::parse($salaryPayment->workMonth)->translatedFormat('F/Y') }}</td>
              </tr>

              <tr>
                <th>Departamento</th>
                <td>{{ $salaryPayment->employee->department->title ?? '-' }}</td>
              </tr>

              <tr>
                <th>Tipo de Funcionário</th>
                <td>{{ $salaryPayment->employee->employeeType->name ?? '-' }}</td>
              </tr>

              <tr>
                <th>IBAN</th>
                <td>{{ $salaryPayment->employee->iban }}</td>
              </tr>

              <tr>
                <th>Salário Básico</th>
                <td>{{ number_format($salaryPayment->baseSalary, 2, ',', '.') }}</td>
              </tr>

              <tr>
                <th>Subsídios</th>
                <td>{{ number_format($salaryPayment->subsidies, 2, ',', '.') }}</td>
              </tr>

              <tr>
                <th>Desconto</th>
                <td>{{ number_format($salaryPayment->discount, 2, ',', '.') }}</td>
              </tr>

              <tr>
                <th>Salário Líquido</th>
                <td class="fw-bold text-success">
                  {{ number_format($salaryPayment->salaryAmount, 2, ',', '.') }}
                </td>
              </tr>

              <tr>
                <th>Data do Pagamento</th>
                <td>{{ \Carbon\Carbon::parse($salaryPayment->paymentDate)->format('d/m/Y') }}</td>
              </tr>

              <tr>
                <th>Status</th>
                <td>
                  @if($salaryPayment->paymentStatus == "Pago")
                    <span class="badge bg-success">Pago</span>
                  @elseif($salaryPayment->paymentStatus == "Pendente")
                    <span class="badge bg-warning text-dark">Pendente</span>
                  @else
                    <span class="badge bg-secondary">{{ $salaryPayment->paymentStatus }}</span>
                  @endif
                </td>
              </tr>

              <tr>
                <th>Comentário</th>
                <td>{{ $salaryPayment->paymentComment ?? '-' }}</td>
              </tr>

              <tr>
                <th>Criado em</th>
                <td>{{ $salaryPayment->created_at->format('d/m/Y H:i') }}</td>
              </tr>

            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>

</div>

@endsection
