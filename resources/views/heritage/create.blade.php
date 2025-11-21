@extends('layouts.admin.layout')
@section('title', 'Novo Patrimônio')

@section('content')
<div class="card my-4 shadow">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span>Novo Patrimônio</span>
        <a href="{{ route('heritage.index') }}" class="btn btn-outline-light btn-sm">
            <i class="fa-solid fa-list"></i>
        </a>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('heritage.store') }}">
            @csrf

            <!-- Descrição -->
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="form-floating">
                        <input type="text" name="Description" id="Description" class="form-control" required 
                               value="{{ old('Description') }}" placeholder="">
                        <label for="Description">Descrição do Patrimônio Ex: Mesa de escritório, Cadeira, Impressora...</label>
                    </div>
                </div>

                <!-- Tipo -->
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" name="Type" id="Type" class="form-control" required 
                               value="{{ old('Type') }}" placeholder="">
                        <label for="Type">Tipo Ex: Mobiliário, Equip. Informático, Veículo, Eletrodoméstico...</label>
                    </div>
                </div>
            </div>

            <!-- Valor + Data Aquisição -->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" step="0.01" name="Value" id="Value" class="form-control" required 
                               value="{{ old('Value') }}" placeholder="">
                        <label for="Value">Valor em Kz</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" name="AcquisitionDate" id="AcquisitionDate" class="form-control" required 
                               value="{{ old('AcquisitionDate') }}">
                        <label for="AcquisitionDate">Data de Aquisição</label>
                    </div>
                </div>
            </div>

            <!-- Localização + Condição -->
            <div class="row g-3 mt-3">
                <div class="col-md-8">
                    <div class="form-floating">
                        <input type="text" name="Location" id="Location" class="form-control" required 
                               value="{{ old('Location') }}" placeholder=" ">
                        <label for="Location">Localização Atual</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="Condition" id="Condition" class="form-select" required>
                            <option value="" disabled selected></option>
                            <option value="novo" {{ old('Condition') == 'novo' ? 'selected' : '' }}>Novo</option>
                            <option value="usado" {{ old('Condition') == 'usado' ? 'selected' : '' }}>Usado</option>
                            <option value="danificado" {{ old('Condition') == 'danificado' ? 'selected' : '' }}>Danificado</option>
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
                                  placeholder="">{{ old('Observations') }}</textarea>
                        <label for="Observations">Observações</label>
                    </div>
                </div>
            </div>

            <!-- Dados ocultos -->
            <input type="hidden" name="FormResponsibleName" value="{{ auth()->user()->name ?? auth()->user()->fullName ?? 'Sistema' }}">
            <input type="hidden" name="FormResponsibleEmail" value="{{ auth()->user()->email }}">
            <input type="hidden" name="FormDate" value="{{ now()->format('Y-m-d') }}">

            <!-- Botão -->
            <div class="d-grid gap-2 col-6 mx-auto mt-5">
                <button type="submit" class="btn btn-success btn-lg">
                    Cadastrar Patrimônio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection