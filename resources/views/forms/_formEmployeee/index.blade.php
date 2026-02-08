<!-- Linha: Departamento, Cargo, Especialidade e Tipo -->
<div class="row g-3">
    <div class="col-md-6">
        <div class="form-floating">
            <select name="departmentId" id="depart" class="form-select"
                {{ isset($employee->departmentId) ? 'disabled' : '' }}>

                <option value="">Selecione</option>

                @foreach ($departments as $item)
                    <option value="{{ $item->id }}"
                        {{ ($employee->departmentId ?? old('departmentId')) == $item->id ? 'selected' : '' }}>
                        {{ $item->title }}
                    </option>
                @endforeach
            </select>
            <label for="depart">Departamento</label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-floating">
            <select name="positionId" id="positionId" class="form-select"
                {{ isset($employee->positionId) ? 'disabled' : '' }}>
                <option value="" selected>Selecione</option>
                @foreach ($positions as $item)
                    <option value="{{ $item->id }}"
                        {{ ($employee->positionId ?? old('positionId')) == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            <label for="positionId">Cargo</label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-floating">
            <select name="roleId" id="roleId" class="form-select">
                <option value="" selected>Selecione</option>
                @foreach ($roles as $item)
                    <option value="{{ $item->id }}"
                        {{ ($employee->roleId ?? old('roleId')) == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            <label for="roleId">Função</label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-floating">
            <select name="specialtyId" id="specialtyId" class="form-select" {{-- {{ isset($employee->specialtyId) ? 'disabled' : '' }} --}}>
                <option value="" selected>Selecione</option>
                @foreach ($specialties as $item)
                    <option value="{{ $item->id }}"
                        {{ ($employee->specialtyId ?? old('specialtyId')) == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            <label for="specialtyId">Especialidade</label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-floating">
            <select name="employeeTypeId" id="employeeTypeId" class="form-select" {{-- {{ isset($employee->employeeTypeId) ? 'disabled' : '' }} --}}>
                <option value="" selected>Selecione</option>
                @foreach ($employeeTypes as $item)
                    <option value="{{ $item->id }}"
                        {{ ($employee->employeeTypeId ?? old('employeeTypeId')) == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            <label for="employeeTypeId">Tipo de Funcionário</label>
        </div>
    </div>
</div>

<!-- Linha: Categoria, Curso, Nível Acadêmico, Gênero -->
<div class="row g-3 mt-3">
    <div class="col-md-3">
        <div class="form-floating">
            <select name="employeeCategoryId" id="employeeCategoryId" class="form-select" {{-- {{ isset($employee->employeeCategoryId) ? 'disabled' : '' }} --}}>
                <option value="" selected>Selecione</option>
                @foreach ($employeeCategories as $item)
                    <option value="{{ $item->id }}"
                        {{ ($employee->employeeCategoryId ?? old('employeeCategoryId')) == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            <label for="employeeCategoryId">Categoria</label>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-floating">
            <select name="courseId" id="courseId" class="form-select">
                <option value="" selected>Selecione</option>
                @foreach ($courses as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <label for="courseId">Curso</label>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-floating">
            <input type="text" name="academicLevel" id="academicLevel" class="form-control" placeholder=""
                value="{{ old('academicLevel', $employee->academicLevel ?? '') }}">
            <label for="academicLevel">Nível Acadêmico</label>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-floating">
            <select name="gender" id="gender" class="form-select">
                <option value="" {{ old('gender', $employee->gender ?? '') == '' ? 'selected' : '' }}>Selecione
                </option>
                <option value="Masculino"
                    {{ old('gender', $employee->gender ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Feminino" {{ old('gender', $employee->gender ?? '') == 'Feminino' ? 'selected' : '' }}>
                    Feminino</option>
            </select>
            <label for="gender">Gênero</label>
        </div>
    </div>
</div>

<!-- Linha: Nome Completo e Email -->
<div class="row g-3 mt-3">
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" name="fullName" id="fullName" class="form-control" placeholder=""
                value="{{ old('fullName', $employee->fullName ?? '') }}">
            <label for="fullName">Nome Completo</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" name="email" id="email" class="form-control" placeholder="nome.sobrenome apenas"
                value="{{ old('email', $employee->email ?? '') }}">
            <label for="email"></label>
        </div>
    </div>
</div>

<!-- Linha: Endereço e Telefone -->
<div class="row g-3 mt-3">
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" name="address" id="address" class="form-control" placeholder=""
                value="{{ old('address', $employee->address ?? '') }}">
            <label for="address">Endereço</label>
        </div>
    </div>

    <div class="col-md-6">

        <div class="input-group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false" id="selected_code" style="height: calc(3.5rem + 5px);">
                Selecione o Código
            </button>
            <ul class="dropdown-menu" id="phone_code_menu" style="max-height: 30em; overflow-y: auto;"></ul>
            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Telefone"
                maxlength="16" value="{{ old('mobile', $employee->mobile ?? '') }}">
            <input type="hidden" name="phoneCode" id="phoneCode"
                value="{{ old('phoneCode', $employee->phoneCode ?? '') }}">
        </div>
    </div>

    {{-- data de nascimento --}}
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" name="birth_date" id="birth_date" class="form-control"
                value="{{ old('birth_date', $employee->birth_date ?? '') }}" max="{{ date('Y-m-d') }}"
                min="{{ \Carbon\Carbon::now()->subYears(120)->format('Y-m-d') }}">
            <label for="birth_date">Data de Nascimento</label>
        </div>
    </div>
    {{-- data de ingresso --}}
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" name="entry_date" id="entry_date" class="form-control"
                value="{{ old('entry_date', $employee->entry_date ?? '') }}">
            <label for="entry_date">Data de Ingresso</label>
        </div>
    </div>
</div>

<!-- Linha: Nacionalidade, IBAN -->
<div class="row g-3 mt-3">
    <div class="col-md-4">
        <div class="form-floating">
            <select name="nationality" id="nationality" class="form-select">
                <option value="">Selecione seu país</option>
            </select>
            <label for="nationality">Nacionalidade</label>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-floating">
            <input type="text" name="iban" id="iban" class="form-control" placeholder=""
                value="AO06{{ old('iban', $employee->iban ?? '') ? substr(old('iban', $employee->iban ?? ''), 4) : '' }}"
                maxlength="25" pattern="AO06[0-9]{21}" title="O IBAN deve começar por AO06 seguido de 21 dígitos.">
            <label for="iban">IBAN</label>
        </div>
    </div>
</div>

<!-- Linha: Foto -->
<div class="row g-3 mt-3">
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" name="bi" id="bi" class="form-control" maxlength="16"
                value="{{ old('bi', $employee->bi ?? '') }}">
            <label for="bi">Bilhete de Identidade / Passaporte</label>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-floating">
            <input type="file" name="biPhoto" id="biPhoto" class="form-control">
            <label for="biPhoto">Cópia do BI / Passaporte</label>
        </div>
        @isset ($employee->biPhoto)
            <small class="text-success">Arquivo atual: <a
                    href="{{ asset('frontend/images/biPhotos/' . $employee->biPhoto) }}"
                    target="_blank">Ver</a></small>
        @endisset
    </div>

</div>
<!-- Linha: Foto, número do processo -->
<div class="row g-3 mt-3">
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" name="processNumber" id="processNumber" class="form-control" maxlength="16"
                value="{{ old('processNumber', $employee->processNumber ?? '') }}">
            <label for="bi">Número do Processo</label>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-floating">
            <input type="file" name="photo" id="photo" class="form-control">
            <label for="photo">Fotografia</label>
        </div>

    </div>
</div>



<!-- Botão -->
<div class="d-grid gap-2 col-6 mx-auto mt-4">
    @if (isset($employee))
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-save me-2"></i>Atualizar Funcionário
        </button>
    @else
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-check-circle me-2"></i>Cadastrar Funcionário
        </button>
    @endif

</div>
