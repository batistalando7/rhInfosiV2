<div class="row">
    <h3>Informações sobre o produto</h3>
    <hr>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="text" name="name" id="name" class="form-control" placeholder=""
                value="{{ old('name', $infrastructure->name ?? '') }}" required>
            <label for="name">Nome do Produto</label>
        </div>
    </div>
    {{-- <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="text" name="materialType" id="materialType" class="form-control" required>
            <label for="materialTypeId">Tipo de Material</label>
        </div>
    </div> --}}
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="text" name="serialNumber" id="serialNumber" class="form-control" placeholder=""
                value="{{ old('serialNumber', $infrastructure->serialNumber ?? '') }}" >
            <label for="serialNumber">Número de Série</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="text" name="macAddress" id="macAddress" class="form-control" placeholder=""
                value="{{ old('macAddress', $infrastructure->macAddress ?? '') }}" >
            <label for="macAddress">Endereço MAC</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="text" name="model" id="model" class="form-control" placeholder=""
                value="{{ old('model', $infrastructure->model ?? '') }}" required>
            <label for="model">Modelo</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="date" name="manufactureDate" id="manufactureDate" class="form-control" placeholder=""
                value="{{ old('manufactureDate', $infrastructure->manufactureDate ?? '') }}" required>
            <label for="manufactureDate">Data de Fabrico</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <select name="supplierId" id="supplierId" class="form-select" placeholder=""
                value="{{ old('supplierId') }}" required>
                <option value="{{ $infrastructure->supplierId ?? ''}}">{{ $infrastructure->supplier->name ?? 'Selecione'}}</option>
                @foreach ($supplier as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <label for="supplierId">Fornecedor</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="date" name="entryDate" id="entryDate" class="form-control" placeholder=""
                value="{{ old('entryDate', $infrastructure->entryDate ?? '') }}" required>
            <label for="entryDate">Data de Entrada</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="number" name="quantity" id="quantity" class="form-control" placeholder=""
                value="{{ old('quantity', $infrastructure->quantity ?? '') }}" min="0" required>
            <label for="quantity">Qtd. Inicial em Estoque</label>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="form-floating">
            <input type="file" name="document" id="document" class="form-control" placeholder="">
            <label for="document">Documento</label>
            @isset($infrastructure->document)
                <small>Documento actual <a href="{{ route('file/'.$infrastructure->document )}}" class="text-success">ver</a></small>
            @endisset
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="form-floating">
            <textarea name="Notes" id="Notes" class="form-control" placeholder="" style="height: 100px;">{{ old('Notes') }}</textarea>
            <label for="Notes">Observações</label>
        </div>
    </div>
</div>
<div class="d-grid gap-2 col-4 mx-auto mt-4">
    <button class="btn btn-success"><i class="fas fa-check-circle me-1"></i> Salvar</button>
</div>
