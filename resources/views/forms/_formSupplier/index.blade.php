<div class="row g-3">
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" name="name" id="name" class="form-control" maxlength="12" placeholder=""
                value="{{ old('name', $supplier->name ?? '') }}" required>
            <label for="name">Nome</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" name="nif" id="nif" class="form-control" placeholder=""
                value="{{ old('nif', $supplier->nif ?? '') }}" required>
            <label for="nif">NIF</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" name="address" id="address" class="form-control" placeholder=""
                value="{{ old('address', $supplier->address ?? '') }}" required>
            <label for="address">Endereço</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" name="site" id="site" class="form-control" placeholder=""
                value="{{ old('site', $supplier->site ?? '') }}" required min="1900"
                max="{{ date('Y') }}">
            <label for="site">Site</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" name="email" id="email" class="form-control" placeholder=""
                value="{{ old('email', $supplier->email ?? '') }}" required min="1900"
                max="{{ date('Y') }}">
            <label for="email">E-mail</label>
        </div>
    </div>
</div>
{{-- <div class="row g-3 mt-3">
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" name="color" id="color" class="form-control" placeholder=""
                value="{{ old('color', $supplier->color ?? '') }}" required>
            <label for="color">Cor</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-floating">
            <input type="number" name="loadCapacity" id="loadCapacity" class="form-control" placeholder=""
                value="{{ old('loadCapacity', $supplier->loadCapacity ?? '') }}" required min="1">
            <label for="loadCapacity">Total de Lugares</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-floating">
            <select name="status" id="status" class="form-select">
                <option value="Available" {{ old('status', $supplier->status ?? '') == 'Available' ? 'selected' : '' }}>
                    Disponível</option>
                <option value="UnderMaintenance"
                    {{ old('status', $supplier->status ?? '') == 'UnderMaintenance' ? 'selected' : '' }}>Em Manutenção
                </option>
                <option value="Unavailable"
                    {{ old('status', $supplier->status ?? '') == 'Unavailable' ? 'selected' : '' }}>
                    Indisponível</option>
            </select>
            <label for="status">Status</label>
        </div>
    </div>
</div>
<div class="row g-3 mt-3">
    <div class="col-md-6">
        <div class="form-floating">
            <input type="file" name="document" id="document" class="form-control"
                value="{{ old('document', $supplier->document ?? '') }}">
            <label for="document">Documento da Viatura</label>
        </div>
        <div class="form-text">
            <small>Formato aceito: PDF, JPG, PNG. Tamanho máximo: 2MB.</small>
            @if (isset($supplier) && $supplier->document)
                @php
                    $verDocumento = asset('storage/documents/suppliers/' . $supplier->document);
                @endphp
                <small><a href="{{ $verDocumento }}" target="_blank" class="text-decoration-underline">ver</a></small>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating">
            <textarea name="notes" id="notes" class="form-control" placeholder="" style="height:60px">{{ old('notes', $supplier->notes ?? '') }}</textarea>
            <label for="notes">Observações</label>
        </div>
    </div>
</div> --}}
@if (isset($supplier))
    <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="fas fa-check-circle me-2"></i>Atualizar Fornecedor
        </button>
    </div>
@else
    <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="fas fa-check-circle me-2"></i>Cadastrar Fornecedor
        </button>
    </div>
@endif
