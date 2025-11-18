@extends('layouts.admin.layout')
@section('title','Adicionar Pagamento de Salário')
@section('content')
<div class="row justify-content-center" style="margin-top: 1.5rem;">
  <div class="col-md-7">
    <div class="card mb-4 shadow">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Adicionar Pagamento de Salário</h4>
        <a href="{{ route('salaryPayment.index') }}" class="btn btn-outline-light btn-sm">
          <i class="fas fa-arrow-left"></i> Voltar
        </a>
      </div>

      <div class="card-body">
        <form id="salaryForm" method="POST" action="{{ route('salaryPayment.store') }}">
          @csrf

          <!-- CAMPO ÚNICO E PERFEITO -->
          <div class="mb-4">
            <label class="form-label">Funcionário <span class="text-danger">*</span></label>
            <input type="text" 
                   id="employeeSearch" 
                   class="form-control" 
                   placeholder="Digite o nome do funcionário..." 
                   autocomplete="off">
            <input type="hidden" name="employeeId" id="employeeId" required>
            @error('employeeId')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <!-- Dados do funcionário -->
          <div id="employeeInfo" class="row mb-4 p-3 border rounded bg-light d-none">
            <div class="col-md-6"><strong>Nome:</strong> <span id="empName">-</span></div>
            <div class="col-md-6"><strong>Departamento:</strong> <span id="empDept">-</span></div>
            <div class="col-md-6"><strong>E-mail:</strong> <span id="empEmail">-</span></div>
            <div class="col-md-6"><strong>IBAN:</strong> <span id="empIban">-</span></div>
          </div>

          <!-- Mês -->
          <div class="mb-3">
            <label class="form-label">Mês de Competência <span class="text-danger">*</span></label>
            <select name="workMonth" id="workMonth" class="form-select" required>
              @for($i = 0; $i <= 11; $i++)
                @php $m = now()->subMonths($i) @endphp
                <option value="{{ $m->format('Y-m') }}" {{ $m->isCurrentMonth() ? 'selected' : '' }}>
                  {{ $m->translatedFormat('F Y') }}
                </option>
              @endfor
            </select>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Salário Básico (Kz) <span class="text-danger">*</span></label>
              <input type="text" name="baseSalary" id="baseSalary" class="form-control currency" value="0,00" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Subsídios (Kz) <span class="text-danger">*</span></label>
              <input type="text" name="subsidies" id="subsidies" class="form-control currency" value="0,00" required>
            </div>
          </div>

          <div class="row g-3 mt-3">
            <div class="col-md-6">
              <label class="form-label">IRT (%) <span class="text-danger">*</span></label>
              <input type="text" name="irtRate" id="irtRate" class="form-control currency" value="0,00" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">INSS (%) <span class="text-danger">*</span></label>
              <input type="text" name="inssRate" id="inssRate" class="form-control currency" value="0,00" required>
            </div>
          </div>

          <div class="mt-3">
            <label class="form-label">Desconto por Faltas (Kz)</label>
            <input type="text" name="discount" id="discount" class="form-control currency" value="0,00" readonly>
            <small id="absentInfo" class="form-text text-muted"></small>
          </div>

          <div class="row g-3 mt-3">
            <div class="col-md-6">
              <label class="form-label">Data de Pagamento</label>
              <input type="date" name="paymentDate" class="form-control" value="{{ now()->format('Y-m-d') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Status <span class="text-danger">*</span></label>
              <select name="paymentStatus" class="form-select" required>
                <option value="Pending">Pendente</option>
                <option value="Completed" selected>Concluído</option>
                <option value="Failed">Falhou</option>
              </select>
            </div>
          </div>

          <div class="mt-3">
            <label class="form-label">Comentário</label>
            <textarea name="paymentComment" class="form-control" rows="3"></textarea>
          </div>

          <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg px-5">
              <i class="fas fa-check-circle"></i> Salvar Pagamento
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  /* O SEGREDO: essas linhas fazem o Select2 parecer 100% um input normal */
  .select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    height: 48px;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 46px;
    padding-left: 12px;
    color: #495057;
  }
  .select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #6c757d;
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 46px;
  }
  .select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(function () {
  $('#employeeSearch').select2({
    placeholder: "Digite o nome do funcionário...",
    allowClear: true,
    minimumInputLength: 2,
    ajax: {
      url: '{{ route("salaryPayment.searchEmployeeAjax") }}',
      dataType: 'json',
      delay: 300,
      data: params => ({ q: params.term }),
      processResults: data => ({ results: data })
    },
    templateResult: item => item.loading ? 'Buscando...' : item.text + ' <small class="text-muted">(' + item.extra + ')</small>',
    templateSelection: item => item.text || "Digite o nome do funcionário..."
  });

  $('#employeeSearch').on('select2:select', e => {
    const d = e.params.data;
    $('#employeeId').val(d.id);
    $('#empName').text(d.text);
    $('#empDept').text(d.extra.replace('Depto: ', ''));
    $('#employeeInfo').removeClass('d-none');
    updateDiscount();
  });

  $('#employeeSearch').on('select2:clear', () => {
    $('#employeeId').val('');
    $('#employeeInfo').addClass('d-none');
  });

  $('.currency').mask('#.##0,00', { reverse: true });

  function updateDiscount() {
    if (!$('#employeeId').val()) return;
    const base = parseFloat($('#baseSalary').val().replace(/\./g,'').replace(',','.')) || 0;
    const subs = parseFloat($('#subsidies').val().replace(/\./g,'').replace(',','.')) || 0;
    const month = $('#workMonth').val();

    fetch(`{{ route('salaryPayment.calculateDiscount') }}?employeeId=${$('#employeeId').val()}&baseSalary=${base}&subsidies=${subs}&workMonth=${month}`)
      .then(r => r.json())
      .then(j => {
        $('#discount').val(Number(j.discount).toLocaleString('pt-AO', {minimumFractionDigits: 2}));
        $('#absentInfo').text(`Faltas injustificadas em ${month.replace('-', '/')} : ${j.absentDays} dia(s)`);
      });
  }

  $('#baseSalary, #subsidies, #workMonth').on('keyup change', updateDiscount);
});
</script>
@endpush
@endsection