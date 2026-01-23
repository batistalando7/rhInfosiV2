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
        <form action="{{ route('admin.employeee.filter.pdf')}}" target="_blank" method="post">
          @csrf
          <!-- Campos ocultos para manter os filtros -->
          <input type="hidden" name="start_date" value="{{ request('start_date', $start ?? '') }}">
          <input type="hidden" name="end_date" value="{{ request('end_date', $end ?? '') }}">
          <input type="hidden" name="departmentId" value="{{ request('departmentId', $selectedDepartment ?? '') }}">
          <input type="hidden" name="positionId" value="{{ request('positionId', $selectedPosition ?? '') }}">
          <input type="hidden" name="specialityId" value="{{ request('specialityId', $selectedSpeciality ?? '') }}">
          <input type="hidden" name="employeeTypeId" value="{{ request('employeeTypeId', $selectedType ?? '') }}">
          <input type="hidden" name="employeeCategoryId" value="{{ request('employeeCategoryId', $selectedCategory ?? '') }}">
          <input type="hidden" name="courseId" value="{{ request('courseId', $selectedCourse ?? '') }}">
          <button
           class="btn btn-outline-light btn-sm me-2" title="Baixar PDF" target="_blank" rel="noopener noreferrer">
          <i class="fas fa-file-earmark-pdf"></i> Baixar PDF
        </button>
        </form>
      @endif

      <a href="{{ route("admin.employeee.index") }}" class="btn btn-outline-light btn-sm" title="Voltar">
        <i class="fas fa-arrow-left"></i> Voltar
      </a>
    </div>
  </div>
  
  <div class="card-body">
    {{-- Formulário de Filtro --}}
    <form action="{{ route("admin.employeee.filter") }}" method="GET" class="mb-4">
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
                @if($selectedDepartment != null)
                <th>Departamento</th>
                @endif
                @if($selectedPosition != null)
                <th>Cargo</th>
                @endif
                @if($selectedSpeciality != null)
                <th>Especialidade</th>
                @endif
                @if($selectedType != null)
                <th>Tipo de Funcionário</th>
                @endif
                <th>Data de Ingresso</th>
              </tr>
            </thead>
            <tbody>
              @foreach($filtered as $emp)
                <tr>
                  <td>{{ $emp->id }}</td>
                  <td>{{ $emp->fullName }}</td>
                  @if($selectedDepartment != null)
                  <td>{{ $emp->department->title ?? "-" }}</td>
                  @endif
                  @if($selectedPosition != null)
                  <td>{{ $emp->position->name ?? "-" }}</td>
                  @endif
                  @if($selectedSpeciality != null)
                  <td>{{ $emp->specialty->name ?? "-" }}</td>
                  @endif
                  @if($selectedType != null)
                  <td>{{ $emp->employeeType->name ?? "-" }}</td>
                  @endif
                  <td>{{ \Carbon\Carbon::parse($emp->entry_date)->format("d/m/Y") }}</td>
                  
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