@extends('layouts.admin.layout')
@section('title', 'Criar Administrador')
@section('content')

<div class="card mb-4 mt-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-plus-circle me-2"></i>Novo Administrador</span>
    <a href="{{ route('admins.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
      <i class="fa-solid fa-list"></i>
    </a>
  </div>

  <div class="card-body">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <form method="POST" action="{{ route('admins.store') }}" enctype="multipart/form-data">
          @csrf

          <!-- Seleção de Funcionário -->
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="form-floating">
                <select name="employeeId" id="employeeId" class="form-select">
                  <option value="">Selecione um Funcionário (Opcional)</option>
                  @foreach($employees as $employee)
                    <option value="{{ $employee->id }}"
                            data-email="{{ $employee->email }}"
                            data-fullname="{{ $employee->fullName }}"
                            data-photo="{{ $employee->photo ? asset('frontend/images/departments/'.$employee->photo) : asset('frontend/images/default.png') }}">
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
                <label for="employeeFullName">Nome do Funcionário</label>
              </div>
            </div>
          </div>

          <!-- Preview da Foto -->
          <div class="text-center mb-4" id="employeePhotoContainer" style="display: none;">
            <img id="employeePhoto" src="" alt="Foto do Funcionário" class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
            <p class="text-muted mt-2"><small>Foto atual do funcionário vinculado</small></p>
          </div>

          <!-- Papel e Email -->
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="form-floating">
                <select name="role" id="role" class="form-select" required>
                  <option value="">Selecione o Papel</option>
                  <option value="admin">Administrador</option>
                  <option value="director">Diretor</option>
                  <option value="department_head">Chefe de Departamento</option>
                  <option value="employee">Funcionário</option>
                </select>
                <label for="role">Papel *</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="email" name="email" id="email" class="form-control" placeholder=" " required>
                <label for="email">Email *</label>
              </div>
            </div>
          </div>

          <!-- Campos para Chefe de Departamento -->
          <div id="department_head_fields" style="display: none;" class="mb-4">
            <h5 class="text-primary mb-3"><i class="fas fa-user-tie me-2"></i>Chefe de Departamento</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <div class="form-floating">
                  <select name="department_id" id="department_id" class="form-select">
                    <option value="">Selecione o Departamento</option>
                    @foreach($departments as $dept)
                      <option value="{{ $dept->id }}">{{ $dept->title }}</option>
                    @endforeach
                  </select>
                  <label for="department_id">Departamento</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" name="department_head_name" id="department_head_name" class="form-control" placeholder=" ">
                  <label for="department_head_name">Nome do Chefe</label>
                </div>
              </div>
            </div>
            <div class="row g-3 mt-3">
              <div class="col-md-12">
                <label for="photo" class="form-label">Foto do Chefe (opcional – usa a do funcionário se não enviar nova)</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
              </div>
            </div>
          </div>

          <!-- Campos para Diretor -->
          <div id="director_fields" style="display: none;" class="mb-4">
            <h5 class="text-primary mb-3"><i class="fas fa-crown me-2"></i>Diretor</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <div class="form-floating">
                  <select name="directorType" id="directorType" class="form-select">
                    <option value="">Selecione o Tipo</option>
                    <option value="directorGeneral">Director(a) Geral</option>
                    <option value="directorTechnical">Director(a) da Área Técnica</option>
                    <option value="directorAdministrative">Director(a) Adjunta Administrativa</option>
                  </select>
                  <label for="directorType">Tipo de Diretor</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" name="directorName" id="directorName" class="form-control" placeholder=" ">
                  <label for="directorName">Nome do Diretor</label>
                </div>
              </div>
            </div>
            <div class="row g-3 mt-3">
              <div class="col-md-6">
                <div class="form-floating">
                  <textarea name="biography" class="form-control" style="height: 120px;" placeholder=" "></textarea>
                  <label>Biografia</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="url" name="linkedin" class="form-control" placeholder=" ">
                  <label>LinkedIn</label>
                </div>
              </div>
            </div>
            <div class="row g-3 mt-3">
              <div class="col-md-12">
                <label for="directorPhoto" class="form-label">Foto do Diretor (opcional – usa a do funcionário se não enviar nova)</label>
                <input type="file" name="directorPhoto" class="form-control" accept="image/*">
              </div>
            </div>
          </div>

          <!-- Senhas -->
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="form-floating">
                <input type="password" name="password" class="form-control" placeholder=" " required>
                <label>Senha * (mín. 6 caracteres)</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="password" name="password_confirmation" class="form-control" placeholder=" " required>
                <label>Confirmar Senha *</label>
              </div>
            </div>
          </div>

          <!-- Botão -->
          <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="fas fa-check-circle me-2"></i>Criar Administrador
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function populateRoleFields(fullName) {
    const role = document.getElementById('role').value;
    document.getElementById('department_head_name').value = role === 'department_head' ? fullName : '';
    document.getElementById('directorName').value = role === 'director' ? fullName : '';
  }

  function toggleRequiredFields() {
    const role = document.getElementById('role').value;
    document.getElementById('directorType').required = (role === 'director');
    document.getElementById('directorName').required = (role === 'director');
    document.getElementById('department_id').required = (role === 'department_head');
    document.getElementById('department_head_name').required = (role === 'department_head');
  }

  document.getElementById('employeeId').addEventListener('change', function () {
    const sel = this.options[this.selectedIndex];
    const email = sel.getAttribute('data-email') || '';
    const name = sel.getAttribute('data-fullname') || '';
    const photo = sel.getAttribute('data-photo') || '';

    document.getElementById('email').value = email;
    document.getElementById('employeeFullName').value = name;
    document.getElementById('employeePhoto').src = photo;
    document.getElementById('employeePhotoContainer').style.display = this.value ? 'block' : 'none';

    populateRoleFields(name);
  });

  document.getElementById('role').addEventListener('change', function () {
    const isHead = this.value === 'department_head';
    const isDirector = this.value === 'director';

    document.getElementById('department_head_fields').style.display = isHead ? 'block' : 'none';
    document.getElementById('director_fields').style.display = isDirector ? 'block' : 'none';

    populateRoleFields(document.getElementById('employeeFullName').value);
    toggleRequiredFields();
  });

  toggleRequiredFields();
</script>

@endsection