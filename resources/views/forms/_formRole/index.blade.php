<div class="mb-3">
    <div class="form-floating">
        <input type="text" name="name" class="form-control" id="name" placeholder=""
            value="{{ old('name', $role->name ?? '') }}">
        <label for="name">Função</label>
    </div>
</div>

<div class="mb-3">
    <div class="form-floating">
        <textarea name="description" class="form-control" id="description" style="height: 100px;">{{ old('description', $role->description ?? '') }}</textarea>
        <label for="description">Descrição</label>
    </div>
</div>

@if (isset($role))
    <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="fas fa-check-circle me-2"></i>Atualizar 
        </button>
    </div>
@else
    <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="fas fa-check-circle me-2"></i>Cadastrar 
        </button>
    </div>
@endif