@extends('layouts.admin.layout')
@section('title', 'Editar Pagamento de Salário')
@section('content')

<div class="row justify-content-center" style="margin-top: 1.5rem;">
  <div class="col-md-7">
    <div class="card mb-4 shadow">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Editar Pagamento de Salário</h4>
        <a href="{{ route('salaryPayment.index') }}" class="btn btn-outline-light btn-sm">
          <i class="fas fa-arrow-left"></i> Voltar
        </a>
      </div>

      <div class="card-body">

        <!-- Dados do Funcionário (sempre visíveis) -->
        <div class="row mb-4 border p-3 rounded bg-light">
          <div class="col-md-6"><strong>Nome:</strong> {{ $salaryPayment->employee->fullName }}</div>
          <div class="col-md-6"><strong>Departamento:</strong> {{ $salaryPayment->employee->department->title ?? '-' }}</div>
          <div class="col-md-6"><strong>E-mail:</strong> {{ $salaryPayment->employee->email }}</div>
          <div class="col-md-6"><strong>IBAN:</strong> {{ $salaryPayment->employee->iban ?? '-' }}</div>
        </div>

        <form id="salaryForm" method="POST" action="{{ route('salaryPayment.update', $salaryPayment->id) }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="employeeId" value="{{ $salaryPayment->employeeId }}">

          <!-- Mês de Competência -->
          <div class="mb-3">
            <label class="form-label">Mês de Competência <span class="text-danger">*</span></label>
            @php
              $current = now();
              $start   = $current->copy()->subMonths(11)->startOfMonth();
              $end     = $current->copy()->startOfMonth();
            @endphp
            <select name="workMonth" id="workMonth" class="form-select" required>
              @while($start->lte($end))
                <option value="{{ $start->format('Y-m') }}"
                  {{ old('workMonth', \Carbon\Carbon::parse($salaryPayment->workMonth)->format('Y-m')) == $start->format('Y-m') ? 'selected' : '' }}>
                  {{ $start->translatedFormat('F Y') }}
                </option>
                @php $start->addMonth() @endphp
              @endwhile
            </select>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Salário Básico (Kz) <span class="text-danger">*</span></label>
              <input type="text" name="baseSalary" id="baseSalary" class="form-control currency"
                     value="{{ old('baseSalary', number_format($salaryPayment->baseSalary, 2, ',', '.')) }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Subsídios (Kz) <span class="text-danger">*</span></label>
              <input type="text" name="subsidies" id="subsidies" class="form-control currency"
                     value="{{ old('subsidies', number_format($salaryPayment->subsidies, 2, ',', '.')) }}" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">IRT (%) <span class="text-danger">*</span></label>
              <input type="text" name="irtRate" id="irtRate" class="form-control currency"
                     value="{{ old('irtRate', number_format($salaryPayment->irtRate, 2, ',', '.')) }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">INSS (%) <span class="text-danger">*</span></label>
              <input type="text" name="inssRate" id="inssRate" class="form-control currency"
                     value="{{ old('inssRate', number_format($salaryPayment->inssRate, 2, ',', '.')) }}" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Desconto por Faltas (Kz)</label>
            <input type="text" name="discount" id="discount" class="form-control currency" readonly
                   value="{{ old('discount', number_format($salaryPayment->discount, 2, ',', '.')) }}">
            <small id="absentInfo" class="form-text text-muted"></small>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Data de Pagamento</label>
              <input type="date" name="paymentDate" class="form-control"
                     value="{{ old('paymentDate', $salaryPayment->paymentDate) }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Status do Pagamento <span class="text-danger">*</span></label>
              <select name="paymentStatus" class="form-select" required>
                <option value="Pending"   {{ old('paymentStatus', $salaryPayment->paymentStatus) == 'Pending'   ? 'selected' : '' }}>Pendente</option>
                <option value="Completed" {{ old('paymentStatus', $salaryPayment->paymentStatus) == 'Completed' ? 'selected' : '' }}>Concluído</option>
                <option value="Failed"    {{ old('paymentStatus', $salaryPayment->paymentStatus) == 'Failed'    ? 'selected' : '' }}>Falhou</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Comentário</label>
            <textarea name="paymentComment" class="form-control" rows="3">{{ old('paymentComment', $salaryPayment->paymentComment) }}</textarea>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-success btn-lg px-5">
              <i class="fas fa-check-circle"></i> Atualizar Pagamento
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const baseEl  = document.getElementById('baseSalary');
    const subsEl  = document.getElementById('subsidies');
    const monthEl = document.getElementById('workMonth');
    const discEl  = document.getElementById('discount');
    const infoEl  = document.getElementById('absentInfo');
    const empId   = {{ $salaryPayment->employeeId }};

    const unmask = v => parseFloat(v.replace(/\./g,'').replace(/,/g,'.')) || 0;
    const mask   = v => v.toFixed(2).replace('.',',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    function updateDiscount() {
      const base = unmask(baseEl.value);
      const subs = unmask(subsEl.value);
      const wm   = monthEl.value;

      if (!wm || !empId) return;

      fetch(`{{ route('salaryPayment.calculateDiscount') }}?employeeId=${empId}&baseSalary=${base}&subsidies=${subs}&workMonth=${wm}`)
        .then(r => r.json())
        .then(json => {
          discEl.value = mask(json.discount);
          infoEl.textContent = `Faltas injustificadas em ${wm.replace('-', '/')} : ${json.absentDays} dia(s)`;
        })
        .catch(() => infoEl.textContent = 'Erro ao calcular faltas');
    }

    [baseEl, subsEl, monthEl].forEach(el => el.addEventListener('change', updateDiscount));
    [baseEl, subsEl].forEach(el => el.addEventListener('keyup', updateDiscount));

    // Máscara de moeda brasileira
    $('.currency').mask('#.##0,00', {reverse: true});

    // Calcula na carga da página
    updateDiscount();
  });
</script>
@endpush

@endsection