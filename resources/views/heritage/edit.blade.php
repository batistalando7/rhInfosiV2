@extends('layouts.admin.layout')
@section('title', 'Editar Patrimônio')

@section('content')
<div class="card my-4 shadow">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span>Editar Patrimônio #{{ $heritage->id }}</span>
        <a href="{{ route('heritage.index') }}" class="btn btn-outline-light btn-sm">
            <i class="fa-solid fa-list"></i>
        </a>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('heritage.update', $heritage) }}">
            @csrf @method('PUT')

            <!-- Descrição + Tipo -->
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="form-floating">
                        <input type="text" name="Description" id="Description" class="form-control" required
                               value="{{ old('Description', $heritage->Description) }}"
                               placeholder="Mesa de escritório, Computador Dell, Impressora HP...">
                        <label for="Description">Descrição do Patrimônio</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" name="Type" id="Type" class="form-control" required
                               value="{{ old('Type', $heritage->Type) }}"
                               placeholder="Mobiliário, Equip. Informático, Veículo, Eletrodoméstico...">
                        <label for="Type">Tipo</label>
                    </div>
                </div>
            </div>

            <!-- Valor + Data de Aquisição -->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" step="0.01" name="Value" id="Value" class="form-control" required
                               value="{{ old('Value', $heritage->Value) }}"
                               placeholder="0,00">
                        <label for="Value">Valor em Kz</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" name="AcquisitionDate" id="AcquisitionDate" class="form-control" required
                               value="{{ old('AcquisitionDate', $heritage->AcquisitionDate ? $heritage->AcquisitionDate->format('Y-m-d') : '') }}">
                        <label for="AcquisitionDate">Data de Aquisição</label>
                    </div>
                </div>
            </div>

            <!-- Localização + Condição -->
            <div class="row g-3 mt-3">
                <div class="col-md-8">
                    <div class="form-floating">
                        <input type="text" name="Location" id="Location" class="form-control" required
                               value="{{ old('Location', $heritage->Location) }}"
                               placeholder="Sala 12, Armazém Central, Garagem...">
                        <label for="Location">Localização Atual</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="Condition" id="Condition" class="form-select" required>
                            <option value="novo" {{ $heritage->Condition == 'novo' ? 'selected' : '' }}>Novo</option>
                            <option value="usado" {{ $heritage->Condition == 'usado' ? 'selected' : '' }}>Usado</option>
                            <option value="danificado" {{ $heritage->Condition == 'danificado' ? 'selected' : '' }}>Danificado</option>
                        </select>
                        <label for="Condition">Condição</label>
                    </div>
                </div>
            </div>

            <!-- Observações -->
            <div class="row g-3 mt-3">
                <div class="col-12">
                    <div class="form-floating">
                        <textarea name="Observations" id="Observations" class="form-control" style="height: 100px"
                                  placeholder="Observações adicionais (opcional)">{{ old('Observations', $heritage->Observations) }}</textarea>
                        <label for="Observations">Observações</label>
                    </div>
                </div>
            </div>

            <!-- Botão -->
            <div class="d-grid gap-2 col-6 mx-auto mt-5">
                <button type="submit" class="btn btn-success btn-lg">
                    Atualizar Patrimônio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection