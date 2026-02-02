<div class="row">
    <h3>Informações sobre o produto</h3>
    <hr>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <select type="text" name="infrastructureId" id="infrastructureId" class="form-select" placeholder=""
                value="{{ old('infrastructureId') }}" >
                <option value="">selecione</option>
                @foreach ($infrastructure as $item)
                    <option value="{{ $item->id }}"> {{ $item->name }}</option>
                @endforeach
            </select>
            <label for="infrastructureId">Nome</label>
        </div>
    </div>    
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="number" name="CurrentStock" id="CurrentStock" class="form-control" placeholder=""
                value="{{ old('CurrentStock', 0) }}" min="0" >
            <label for="CurrentStock">Qtd. Inicial em Estoque</label>
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
            <textarea name="Notes" id="Notes" class="form-control" placeholder="" style="height: 100px;">{{ old('Notes') }}</textarea>
            <label for="Notes">Observações</label>
        </div>
    </div>
</div>
<div class="d-grid gap-2 col-4 mx-auto mt-4">
    <button class="btn btn-success"><i class="fas fa-check-circle me-1"></i> Salvar</button>
</div>
