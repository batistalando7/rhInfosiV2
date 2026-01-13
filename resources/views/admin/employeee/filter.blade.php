@extends("layouts.admin.layout")
@section("title", "Filtrar Funcionários")
@section("content")

<div class="card my-4 shadow">
  <!-- Cabeçalho com botões -->
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-calendar-event me-2"></i>Filtrar Funcionários</span>

    <div>
      {{-- Se já houver resultados filtrados, para exibir o botão de PDF --}}
      @if(isset($filtered) && $filtered->count() > 0)
        <a href="{{ route("employeee.filter.pdf", [
            "start_date"      => $start ?? null,
            "end_date"        => $end ?? null,
            "employeeTypeId"  => $selectedType ?? null,
        ]) }}"
           class="btn btn-outline-light btn-sm me-2" title="Baixar PDF" target="_blank" rel="noopener noreferrer">
          <i class="fas fa-file-earmark-pdf"></i> Baixar PDF
        </a>
      @endif

      <a href="{{ route("admin.employeee.index") }}" class="btn btn-outline-light btn-sm" title="Voltar">
        <i class="fas fa-arrow-left"></i> Voltar
      </a>
    </div>
  </div>
  
  <div class="card-body">
    {{-- Formulário de Filtro --}}
    <form action="{{ route("employeee.filter") }}" method="GET" class="mb-4">
      <div class="row g-3">
        <!-- Data Inicial -->
        <div class="col-md-3">
          <div class="form-floating">
            <input type="date" name="start_date" class="form-control"
                   value="{{ old("start_date", request("start_date", $start ?? "")) }}">
            <label for="start_date">Data Inicial</label>
          </div>
        </div>

        <!-- Data Final -->
        <div class="col-md-3">
          <div class="form-floating">
            <input type="date" name="end_date" class="form-control"
                   value="{{ old("end_date", request("end_date", $end ?? "")) }}">
            <label for="end_date">Data Final</label>
          </div>
        </div>

        <!-- Departamento -->
        <div class="col-md-3">
          <div class="form-floating">
            <select name="departmentId" class="form-select">
              <option value="" selected>Todos os departamentos</option>
              @foreach($departments as $type)
              <option value="{{ $type->id }}"
                  {{ (request("departmentId", $selectedDepartment ?? "") == $type->id) ? "selected" : "" }}>
                  {{ $type->title }}
                </option>
                @endforeach
            </select>
            <label for="departmentId">Departamento</label>
          </div>
        </div>
        <!-- Cargo -->
        <div class="col-md-3">
          <div class="form-floating">
            <select name="positionId" class="form-select">
              <option value="" selected>Todos os cargos</option>
              @foreach($position as $type)
                <option value="{{ $type->id }}"
                  {{ (request("positionId", $selectedPosition ?? "") == $type->id) ? "selected" : "" }}>
                  {{ $type->name }}
                </option>
                @endforeach
            </select>
            <label for="positionId">Cargo</label>
          </div>
        </div>
        <!-- Especialidade -->
        <div class="col-md-3">
          <div class="form-floating">
            <select name="specialityId" class="form-select">
              <option value="" selected>Todas as Especialidades</option>
              @foreach($speciality as $type)
              <option value="{{ $type->id }}"
                {{ (request("specialityId", $selectedSpeciality ?? "") == $type->id) ? "selected" : "" }}>
                  {{ $type->name }}
                </option>
                @endforeach
            </select>
            <label for="specialityId">Especialidade</label>
          </div>
        </div>
        <!-- Tipo de Funcionário -->
        <div class="col-md-3">
          <div class="form-floating">
            <select name="employeeTypeId" class="form-select">
              <option value="" selected>Todos os Tipos</option>
              @foreach($employeeTypes as $type)
                <option value="{{ $type->id }}"
                  {{ (request("employeeTypeId", $selectedType ?? "") == $type->id) ? "selected" : "" }}>
                  {{ $type->name }}
                </option>
              @endforeach
            </select>
            <label for="employeeTypeId">Tipo de Funcionário</label>
          </div>
        </div>
        <!-- Categoria -->
        <div class="col-md-3">
          <div class="form-floating">
            <select name="employeeCategoryId" class="form-select">
              <option value="" selected>Todas as categorias</option>
              @foreach($employeeCategories as $type)
                <option value="{{ $type->id }}"
                  {{ (request("employeeCategoryId", $selectedType ?? "") == $type->id) ? "selected" : "" }}>
                  {{ $type->name }}
                </option>
              @endforeach
            </select>
            <label for="employeeTypeId">Categorias de Funcionários</label>
          </div>
        </div>
        <!-- Cursos -->
        <div class="col-md-3">
          <div class="form-floating">
            <select name="courseId" class="form-select">
              <option value="" selected>Todos os Cursos</option>
              @foreach($courses as $type)
                <option value="{{ $type->id }}"
                  {{ (request("courseId", $selectedType ?? null) == $type->id) ? "selected" : "" }}>
                  {{ $type->name }}
                </option>
              @endforeach
            </select>
            <label for="courseId">Cursos</label>
          </div>
        </div>

      </div>
      <!-- Botão Filtrar -->
      <div class="col-md-3 m-auto mt-3">
        <button type="submit" class="btn btn-primary w-100">
          <i class="fas fa-search"></i> Filtrar
        </button>
      </div>
    </form>

    <!-- Se existir filtrados($filtered), exibe uma tabela de resultados -->
    @isset($filtered)
      @if($filtered->count() > 0)
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nome Completo</th>
                <th>Departamento</th>
                <th>Cargo</th>
                <th>Especialidade</th>
                <th>Tipo de Funcionário</th>
                <th>Data de Registro</th>
              </tr>
            </thead>
            <tbody>
              @foreach($filtered as $emp)
                <tr>
                  <td>{{ $emp->id }}</td>
                  <td>{{ $emp->fullName }}</td>
                  <td>{{ $emp->department->title ?? "-" }}</td>
                  <td>{{ $emp->position->name ?? "-" }}</td>
                  <td>{{ $emp->specialty->name ?? "-" }}</td>
                  <td>{{ $emp->employeeType->name ?? "-" }}</td>
                  <td>{{ $emp->created_at->format("d/m/Y H:i") }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-center mt-4">Nenhum funcionário encontrado no filtro aplicado.</p>
      @endif
    @endisset

  </div>
</div>
@endsection