@extends('layouts.admin.layout')
@section('title','Adicionar Pagamento de Salário')
@section('content')
<div class="row justify-content-center" style="margin-top: 1.5rem;">
  <div class="col-md-7">
    <div class="card mt-4 shadow">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Adicionar Pagamento de Salário</h4>
        <a href="{{ route('salaryPayment.index') }}" class="btn btn-outline-light btn-sm">
          Voltar
        </a>
      </div>

      <div class="card-body">
        <form id="salaryForm" method="POST" action="{{ route('salaryPayment.store') }}">
          @csrf

          <!-- BUSCA DE FUNCIONÁRIO -->
          <div class="mb-4">
            <label class="form-label">Funcionário <span class="text-danger">*</span></label>
            <div class="position-relative">
              <input type="text" 
                     id="employeeSearch" 
                     class="form-control" 
                     placeholder="Digite o nome do funcionário..." 
                     autocomplete="off">
              <div id="employeeList" class="list-group position-absolute w-100 mt-1 shadow" 
                   style="z-index: 1000; max-height: 300px; overflow-y: auto; display: none;"></div>
            </div>
            <input type="hidden" name="employeeId" id="employeeId" required>
            @error('employeeId')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>

          <!-- DADOS DO FUNCIONÁRIO -->
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

          <!-- DESCONTO AGORA É EDITÁVEL -->
          <div class="mt-3">
            <label class="form-label">Desconto por Faltas (Kz)</label>
            <input type="text" name="discount" id="discount" class="form-control currency" value="0,00">
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

          <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-success btn-lg px-5">
            Salvar Pagamento
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
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('employeeSearch');
  const list = document.getElementById('employeeList');
  const hiddenId = document.getElementById('employeeId');

  // === BUSCA DE FUNCIONÁRIO (igual antes) ===
  searchInput.addEventListener('input', async () => {
    const query = searchInput.value.trim();
    list.innerHTML = '';
    list.style.display = 'none';
    if (query.length < 2) return;

    try {
      const res = await fetch(`{{ route('salaryPayment.searchEmployeeAjax') }}?q=${encodeURIComponent(query)}`);
      const employees = await res.json();

      if (employees.length === 0) {
        list.innerHTML = '<div class="list-group-item text-muted">Nenhum funcionário encontrado</div>';
        list.style.display = 'block';
        return;
      }

      employees.forEach(emp => {
        const item = document.createElement('a');
        item.href = '#';
        item.className = 'list-group-item list-group-item-action';
        item.innerHTML = `<strong>${emp.text}</strong><br><small class="text-muted">${emp.extra}</small>`;
        item.onclick = e => {
          e.preventDefault();
          selectEmployee(emp);
        };
        list.appendChild(item);
      });
      list.style.display = 'block';
    } catch (err) {
      console.error(err);
    }
  });

  function selectEmployee(emp) {
    hiddenId.value = emp.id;
    document.getElementById('empName').textContent = emp.text;
    document.getElementById('empDept').textContent = emp.extra.replace('Depto: ', '');
    document.getElementById('empEmail').textContent = emp.email || '-';
    document.getElementById('empIban').textContent = emp.iban || '-';
    document.getElementById('employeeInfo').classList.remove('d-none');
    searchInput.value = emp.text;
    list.style.display = 'none';
    updateDiscount();
  }

  document.addEventListener('click', e => {
    if (!searchInput.contains(e.target) && !list.contains(e.target)) {
      list.style.display = 'none';
    }
  });

  // === MÁSCARA DE MOEDA ===
  $('.currency').mask('#.##0,00', { reverse: true });

  function formatMoney(value) {
    return Number(value).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  function updateDiscount() {
    if (!hiddenId.value) return;

    const base = parseFloat($('#baseSalary').val().replace(/\./g,'').replace(',','.')) || 0;
    const subs = parseFloat($('#subsidies').val().replace(/\./g,'').replace(',','.')) || 0;
    const month = $('#workMonth').val();

    fetch(`{{ route('salaryPayment.calculateDiscount') }}?employeeId=${hiddenId.value}&baseSalary=${base}&subsidies=${subs}&workMonth=${month}`)
      .then(r => r.json())
      .then(j => {
        $('#discount').val(formatMoney(j.discount));
        $('#absentInfo').text(`Faltas injustificadas em ${month.replace('-', '/')} : ${j.absentDays} dia(s)`);
      });
  }

  $('#baseSalary, #subsidies, #workMonth').on('keyup change', updateDiscount);

  // AQUI ESTÁ A MÁGICA — ANTES DE ENVIAR, LIMPA TUDO!
  document.getElementById('salaryForm').addEventListener('submit', function(e) {
    // Remove máscara e converte para número limpo (ex: 12.345,67 → 12345.67)
    $('.currency').each(function() {
      let val = this.value;
      val = val.replace(/\./g, '');        // remove pontos
      val = val.replace(/,/g, '.');        // vírgula vira ponto
      this.value = parseFloat(val) || 0;   // deixa só o número
    });
  });
});
</script>
@endpush
@endsection