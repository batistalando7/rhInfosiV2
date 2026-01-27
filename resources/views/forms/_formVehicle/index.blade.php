<div class="row g-3">
    <div class="col-md-3">
        <div class="form-floating">
            <input type="text" name="plate" id="plate" class="form-control" maxlength="12" placeholder=""
                value="{{ old('plate', $vehicle->plate ?? '') }}" required>
            <label for="plate">Matrícula</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-floating">
            <input type="text" name="brand" id="brand" class="form-control" placeholder=""
                value="{{ old('brand', $vehicle->brand ?? '') }}" required>
            <label for="brand">Marca</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-floating">
            <input type="text" name="model" id="model" class="form-control" placeholder=""
                value="{{ old('model', $vehicle->model ?? '') }}" required>
            <label for="model">Modelo</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-floating">
            <input type="number" name="yearManufacture" id="yearManufacture" class="form-control" placeholder=""
                value="{{ old('yearManufacture', $vehicle->yearManufacture ?? '') }}" required min="1900"
                max="{{ date('Y') }}">
            <label for="yearManufacture">Ano</label>
        </div>
    </div>
</div>
<div class="row g-3 mt-3">
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" name="color" id="color" class="form-control" placeholder=""
                value="{{ old('color', $vehicle->color ?? '') }}" required>
            <label for="color">Cor</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-floating">
            <input type="number" name="loadCapacity" id="loadCapacity" class="form-control" placeholder=""
                value="{{ old('loadCapacity', $vehicle->loadCapacity ?? '') }}" required min="1">
            <label for="loadCapacity">Total de Lugares</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-floating">
            <select name="status" id="status" class="form-select">
                <option value="Available" {{ old('status', $vehicle->status ?? '') == 'Available' ? 'selected' : '' }}>
                    Disponível</option>
                <option value="UnderMaintenance"
                    {{ old('status', $vehicle->status ?? '') == 'UnderMaintenance' ? 'selected' : '' }}>Em Manutenção
                </option>
                <option value="Unavailable"
                    {{ old('status', $vehicle->status ?? '') == 'Unavailable' ? 'selected' : '' }}>
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
                value="{{ old('document', $vehicle->document ?? '') }}">
            <label for="document">Documento da Viatura</label>
        </div>
        <div class="form-text">
            <small>Formato aceito: PDF, JPG, PNG. Tamanho máximo: 2MB.</small>
            @if (isset($vehicle) && $vehicle->document)
                @php
                    $verDocumento = asset('storage/documents/vehicles/' . $vehicle->document);
                @endphp
                <small><a href="{{ $verDocumento }}" target="_blank" class="text-decoration-underline">ver</a></small>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating">
            <textarea name="notes" id="notes" class="form-control" placeholder="" style="height:60px">{{ old('notes', $vehicle->notes ?? '') }}</textarea>
            <label for="notes">Observações</label>
        </div>
    </div>
</div>
@if (isset($vehicle))
    <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-check-circle me-2"></i>Atualizar Viatura
        </button>
    </div>
@else
    <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-check-circle me-2"></i>Cadastrar Viatura
        </button>
    </div>
@endif
