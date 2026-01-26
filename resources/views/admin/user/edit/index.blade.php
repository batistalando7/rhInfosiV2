@extends('layouts.admin.layout')
@section('title', 'Editar Administrador')
@section('content')

<div class="card mb-4 mt-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-pencil me-2"></i>Editar Administrador</span>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
      <i class="fa-solid fa-list"></i>
    </a>
  </div>

  <div class="card-body">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <form method="POST" action="{{ route('admin.users.update', $admin->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="form-floating">
                <select name="employeeId" id="employeeId" class="form-select">
                  <option value="">Nenhum Funcionário Vinculado</option>
                  @foreach($employees as $employee)
                    <option value="{{ $employee->id }}"
                            data-email="{{ $employee->email }}"
                            data-fullname="{{ $employee->fullName }}"
                            data-photo="{{ $employee->photo ? asset('frontend/images/departments/'.$employee->photo) : asset('frontend/images/default.png') }}"
                            {{ $admin->employeeId == $employee->id ? 'selected' : '' }}>
                      {{ $employee->fullName }}
                    </option>
                  @endforeach
                </select>
                <label for="employeeId">Funcionário Vinculado</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" id="employeeFullName" class="form-control" placeholder=" " readonly>
                <label>Nome do Funcionário</label>
              </div>
            </div>
          </div>

          <div class="text-center mb-4" id="employeePhotoContainer" style="display: none;">
            <img id="employeePhoto" src="" alt="Foto atual" class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
            <p class="text-muted mt-2"><small>Foto atual do funcionário vinculado</small></p>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="form-floating">
                <select name="role" id="role" class="form-select" required>
                  <option value="">Selecione o Papel</option>
                  <option value="admin" {{ $admin->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                  <option value="director" {{ $admin->role == 'director' ? 'selected' : '' }}>Diretor</option>
	                  <option value="department_head" {{ $admin->role == 'department_head' ? 'selected' : '' }}>Chefe de Departamento</option>
	                  <option value="hr" {{ $admin->role == 'hr' ? 'selected' : '' }}>Área Administrativa (RH)</option>
	                  <option value="employee" {{ $admin->role == 'employee' ? 'selected' : '' }}>Funcionário</option>
                </select>
                <label for="role">Papel *</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="email" name="email" id="email" class="form-control" placeholder=" " value="{{ old('email', $admin->email) }}" required>
                <label for="email">Email *</label>
              </div>
            </div>
          </div>

          <!-- Campos Chefe de Departamento -->
          <div id="department_head_fields" style="display: {{ $admin->role === 'department_head' ? 'block' : 'none' }};" class="mb-4">
            <h5 class="text-primary mb-3"><i class="fas fa-user-tie me-2"></i>Chefe de Departamento</h5>
            <div class="row g-3">
              <div class="col-md-12">
                <div class="form-floating">
                  <select name="department_id" id="department_id" class="form-select">
                    <option value="">Selecione o Departamento</option>
                    @foreach($departments as $dept)
                      <option value="{{ $dept->id }}" {{ $admin->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->title }}</option>
                    @endforeach
                  </select>
                  <label for="department_id">Departamento</label>
                </div>
              </div>
            </div>
          </div>

          <!-- Campos Diretor -->
          <div id="director_fields" style="display: {{ $admin->role === 'director' ? 'block' : 'none' }};" class="mb-4">
            <h5 class="text-primary mb-3"><i class="fas fa-crown me-2"></i>Diretor</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <div class="form-floating">
                  <textarea name="biography" class="form-control" style="height: 120px;" placeholder=" ">{{ old('biography', $admin->biography) }}</textarea>
                  <label>Biografia</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="url" name="linkedin" class="form-control" placeholder=" " value="{{ old('linkedin', $admin->linkedin) }}">
                  <label>LinkedIn</label>
                </div>
              </div>
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="form-floating">
                <input type="password" name="password" class="form-control" placeholder=" ">
                <label>Nova Senha (deixe vazio para manter)</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="password" name="password_confirmation" class="form-control" placeholder=" ">
                <label>Confirmar Nova Senha</label>
              </div>
            </div>
          </div>

          <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="fas fa-save me-2"></i>Atualizar Administrador
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function updateEmployeeFields() {
    const select = document.getElementById('employeeId');
    const selected = select.options[select.selectedIndex];
    const emailField = document.getElementById('email');
    const nameField = document.getElementById('employeeFullName');
    const photoContainer = document.getElementById('employeePhotoContainer');
    const photo = document.getElementById('employeePhoto');

    if (select.value) {
      emailField.value = selected.getAttribute('data-email') || '';
      nameField.value = selected.getAttribute('data-fullname') || '';
      photo.src = selected.getAttribute('data-photo') || '';
      photoContainer.style.display = 'block';
    } else {
      emailField.value = '{{ old('email', $admin->email) }}';
      nameField.value = '';
      photoContainer.style.display = 'none';
    }
  }

  function toggleConditionalFields() {
    const role = document.getElementById('role').value;
    document.getElementById('department_head_fields').style.display = (role === 'department_head') ? 'block' : 'none';
    document.getElementById('director_fields').style.display = (role === 'director') ? 'block' : 'none';
  }

  document.getElementById('employeeId').addEventListener('change', updateEmployeeFields);
  document.getElementById('role').addEventListener('change', toggleConditionalFields);

  // Executa ao carregar
  window.addEventListener('load', function() {
    updateEmployeeFields();
    toggleConditionalFields();
  });
</script>

@endsection