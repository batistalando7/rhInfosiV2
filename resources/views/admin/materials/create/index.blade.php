@extends('layouts.admin.layout')
@section('title', 'Novo Material')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-plus-circle me-2"></i> Cadastrar Novo Material
        </div>
        <div class="card-body">
            <form action="{{ route('materials.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select name="materialTypeId" id="materialTypeId" class="form-select" required>
                                <option value="">-- selecione --</option>
                                @foreach ($types as $t)
                                    <option value="{{ $t->id }}" {{ old('materialTypeId') == $t->id ? 'selected' : '' }}>
                                        {{ $t->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="materialTypeId">Tipo de Material</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="Name" id="Name" class="form-control" placeholder=""
                                value="{{ old('Name') }}" required>
                            <label for="Name">Nome</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="SerialNumber" id="SerialNumber" class="form-control" placeholder=""
                                value="{{ old('SerialNumber') }}" required>
                            <label for="SerialNumber">Número de Série</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="Model" id="Model" class="form-control" placeholder=""
                                value="{{ old('Model') }}" required>
                            <label for="Model">Modelo</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="date" name="ManufactureDate" id="ManufactureDate" class="form-control"
                                placeholder="" value="{{ old('ManufactureDate') }}" required>
                            <label for="ManufactureDate">Data de Fabrico</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="SupplierName" id="SupplierName" class="form-control" placeholder=""
                                value="{{ old('SupplierName') }}" required>
                            <label for="SupplierName">Fornecedor</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="SupplierIdentifier" id="SupplierIdentifier" class="form-control"
                                placeholder="" value="{{ old('SupplierIdentifier') }}" required>
                            <label for="SupplierIdentifier">NIF DO FORNECEDOR</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="date" name="EntryDate" id="EntryDate" class="form-control" placeholder=""
                                value="{{ old('EntryDate') }}" required>
                            <label for="EntryDate">Data de Entrada</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="number" name="CurrentStock" id="CurrentStock" class="form-control" placeholder=""
                                value="{{ old('CurrentStock', 0) }}" min="0" required>
                            <label for="CurrentStock">Qtd. Inicial em Estoque</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <textarea name="Notes" id="Notes" class="form-control" placeholder="" style="height: 100px;">{{ old('Notes') }}</textarea>
                            <label for="Notes">Observações</label>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 col-4 mx-auto mt-4">
                    <button class="btn btn-success"><i class="fas fa-check-circle me-1"></i> Salvar</button>
                    <a href="{{ route('materials.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
