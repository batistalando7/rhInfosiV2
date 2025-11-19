@extends('layouts.admin.layout')
@section('title','Editar Pagamento de Salário')
@section('content')
<div class="row justify-content-center" style="margin-top: 1.5rem;">
  <div class="col-md-7">
    <div class="card mb-4 shadow">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Editar Pagamento de Salário</h4>
        <a href="{{ route('salaryPayment.index') }}" class="btn btn-outline-light btn-sm">Voltar</a>
      </div>

      <div class="card-body">
        <form id="salaryForm" method="POST" action="{{ route('salaryPayment.update', $salaryPayment->id) }}">
          @csrf
          @method('PUT')

          <input type="hidden" name="employeeId" value="{{ $salaryPayment->employeeId }}">

          <!-- Funcionário (somente leitura) -->
          <div class="mb-4">
            <label class="form-label">Funcionário</label>
            <input type="text" class="form-control" value="{{ $salaryPayment->employee->fullName }}" readonly>
          </div>

          <!-- Informações do funcionário -->
          <div class="row mb-4 p-3 border rounded bg-light">
            <div class="col-md-6">
              <strong>Departamento:</strong>
              {{ $salaryPayment->employee->department ? $salaryPayment->employee->department->title : 'Sem departamento' }}
            </div>
            <div class="col-md-6"><strong>E-mail:</strong> {{ $salaryPayment->employee->email ?? '-' }}</div>
            <div class="col-md-6"><strong>IBAN:</strong> {{ $salaryPayment->employee->iban ?? '-' }}</div>
          </div>

          <!-- MÊS DE COMPETÊNCIA - AGORA É SELECT IGUAL AO CREATE -->
          <div class="mb-3">
            <label class="form-label">Mês de Competência <span class="text-danger">*</span></label>
            <select name="workMonth" id="workMonth" class="form-select" required>
              @for($i = 0; $i <= 11; $i++)
                @php
                  $m = now()->subMonths($i);
                  $value = $m->format('Y-m');
                  $label = $m->translatedFormat('F Y');
                  $currentMonth = \Carbon\Carbon::parse($salaryPayment->workMonth)->format('Y-m');
                @endphp
                <option value="{{ $value }}" {{ $value == $currentMonth ? 'selected' : '' }}>
                  {{ $label }}
                </option>
              @endfor
            </select>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Salário Básico (Kz) <span class="text-danger">*</span></label>
              <input type="text" name="baseSalary" id="baseSalary" class="form-control currency" 
                     value="{{ number_format($salaryPayment->baseSalary, 2, ',', '.') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Subsídios (Kz) <span class="text-danger">*</span></label>
              <input type="text" name="subsidies" id="subsidies" class="form-control currency" 
                     value="{{ number_format($salaryPayment->subsidies, 2, ',', '.') }}" required>
            </div>
          </div>

          <div class="row g-3 mt-3">
            <div class="col-md-6">
              <label class="form-label">IRT (%) <span class="text-danger">*</span></label>
              <input type="text" name="irtRate" id="irtRate" class="form-control currency" 
                     value="{{ number_format($salaryPayment->irtRate, 2, ',', '.') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">INSS (%) <span class="text-danger">*</span></label>
              <input type="text" name="inssRate" id="inssRate" class="form-control currency" 
                     value="{{ number_format($salaryPayment->inssRate, 2, ',', '.') }}" required>
            </div>
          </div>

          <!-- DESCONTO AGORA RECALCULA AUTOMATICAMENTE -->
          <div class="mt-3">
            <label class="form-label">Desconto por Faltas (Kz)</label>
            <input type="text" name="discount" id="discount" class="form-control currency" 
                   value="{{ number_format($salaryPayment->discount, 2, ',', '.') }}">
            <small id="absentInfo" class="form-text text-muted"></small>
          </div>

          <div class="row g-3 mt-3">
            <div class="col-md-6">
              <label class="form-label">Data de Pagamento</label>
              <input type="date" name="paymentDate" class="form-control" value="{{ $salaryPayment->paymentDate }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Status <span class="text-danger">*</span></label>
              <select name="paymentStatus" class="form-select" required>
                <option value="Pending" {{ $salaryPayment->paymentStatus == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="Completed" {{ $salaryPayment->paymentStatus == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                <option value="Failed" {{ $salaryPayment->paymentStatus == 'Falhou' ? 'selected' : '' }}>Falhou</option>
              </select>
            </div>
          </div>

          <div class="mt-3">
            <label class="form-label">Comentário</label>
            <textarea name="paymentComment" class="form-control" rows="3">{{ $salaryPayment->paymentComment }}</textarea>
          </div>


          <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-success btn-lg px-5">
              Atualizar Pagamento
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(function() {
  $('.currency').mask('#.##0,00', {reverse: true});

  function formatMoney(value) {
    return Number(value).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  function updateDiscount() {
    const employeeId = {{ $salaryPayment->employeeId }};
    const base = parseFloat($('#baseSalary').val().replace(/\./g,'').replace(',','.')) || 0;
    const subs = parseFloat($('#subsidies').val().replace(/\./g,'').replace(',','.')) || 0;
    const month = $('#workMonth').val();

    if (!month) return;

    fetch(`{{ route('salaryPayment.calculateDiscount') }}?employeeId=${employeeId}&baseSalary=${base}&subsidies=${subs}&workMonth=${month}`)
      .then(r => r.json())
      .then(j => {
        $('#discount').val(formatMoney(j.discount));
        $('#absentInfo').text(`Faltas injustificadas em ${month.replace('-', '/')} : ${j.absentDays} dia(s)`);
      })
      .catch(() => {
        $('#absentInfo').text('Erro ao calcular faltas');
      });
  }

  // Recalcula quando mudar salário, subsídio ou mês
  $('#baseSalary, #subsidies, #workMonth').on('keyup change', updateDiscount);

  // Calcula uma vez ao carregar a página
  updateDiscount();

  // Limpa máscara antes de enviar
  $('#salaryForm').on('submit', function() {
    $('.currency').each(function() {
      let val = this.value.replace(/\./g, '').replace(',', '.');
      this.value = parseFloat(val) || 0;
    });
  });
});
</script>
@endpush
@endsection