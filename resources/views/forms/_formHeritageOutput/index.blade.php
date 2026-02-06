<div class="row">
    <h3>Informações sobre o produto</h3>
    <hr>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <select type="text" name="heritageId" id="heritageId" class="form-select" placeholder=""
                value="{{ old('heritageId') }}" >
                <option value="">selecione</option>
                @foreach ($heritages as $item)
                    <option value="{{ $item->id }}"> {{ $item->name }}</option>
                @endforeach
            </select>
            <label for="heritageId">Nome</label>
        </div>
    </div>    
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="text" name="destiny" id="destiny" class="form-control" placeholder=""
                value="{{ old('destiny') }}" >
            <label for="destiny">Destino</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="text" name="responsible" id="responsible" class="form-control" placeholder=""
                value="{{ old('responsible') }}"  >
            <label for="responsible">Responsável</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="number" name="quantity" id="quantity" class="form-control" placeholder=""
                value="{{ old('quantity') }}"  >
            <label for="quantity">Quantidade</label>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="form-floating">
            <input type="file" name="document" id="document" class="form-control" placeholder="">
            <label for="document">Documento</label>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="form-floating">
            <textarea name="notes" id="notes" class="form-control" placeholder="" style="height: 100px;">{{ old('notes') }}</textarea>
            <label for="notes">Observações</label>
        </div>
    </div>
</div>
<div class="d-grid gap-2 col-4 mx-auto mt-4">
    <button class="btn btn-success"><i class="fas fa-check-circle me-1"></i> Salvar</button>
</div>
