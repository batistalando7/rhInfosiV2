@extends('layouts.admin.layout')
@section('title', 'Editar Património')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-pencil me-2"></i> Editar Património: {{ $heritage->Description }}
        </div>
        <div class="card-body">
            <form action="{{ route('heritages.update', $heritage->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    {{-- Informações do Património --}}
                    <h5 class="mb-3 text-primary">Informações do Património</h5>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select name="heritageTypeId" id="heritageTypeId" class="form-select" required>
                                <option value="">-- selecione --</option>
                                @foreach ($types as $t)
                                    <option value="{{ $t->id }}"
                                        {{ old('heritageTypeId', $heritage->heritageTypeId) == $t->id ? 'selected' : '' }}>
                                        {{ $t->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="heritageTypeId">Tipo de Património</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="Description" id="Description" class="form-control" placeholder=""
                                value="{{ old('Description', $heritage->Description) }}" required>
                            <label for="Description">Descrição do Património</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="number" step="0.01" name="Value" id="Value" class="form-control" placeholder=""
                                value="{{ old('Value', $heritage->Value) }}" required>
                            <label for="Value">Valor do Património (MZN)</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="date" name="AcquisitionDate" id="AcquisitionDate" class="form-control" placeholder=""
                                value="{{ old('AcquisitionDate', $heritage->AcquisitionDate->format('Y-m-d')) }}" required>
                            <label for="AcquisitionDate">Data de Aquisição</label>
                        </div>
                    </div>

                    {{-- Localização e Responsável --}}
                    <h5 class="mb-3 mt-3 text-primary">Localização e Responsável</h5>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="Location" id="Location" class="form-control" placeholder=""
                                value="{{ old('Location', $heritage->Location) }}" required>
                            <label for="Location">Localização</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select name="ResponsibleId" id="ResponsibleId" class="form-select">
                                <option value="">-- selecione (opcional) --</option>
                                @foreach ($employees as $e)
                                    <option value="{{ $e->id }}"
                                        {{ old('ResponsibleId', $heritage->ResponsibleId) == $e->id ? 'selected' : '' }}>
                                        {{ $e->fullName }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="ResponsibleId">Responsável</label>
                        </div>
                    </div>

                    {{-- Estado e Observações --}}
                    <h5 class="mb-3 mt-3 text-primary">Estado e Observações</h5>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select name="Condition" id="Condition" class="form-select" required>
                                <option value="">-- selecione --</option>
                                @foreach (['Novo', 'Usado', 'Danificado', 'Em Manutenção', 'Avariado'] as $condition)
                                    <option value="{{ $condition }}"
                                        {{ old('Condition', $heritage->Condition) == $condition ? 'selected' : '' }}>
                                        {{ $condition }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="Condition">Condição</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <textarea name="Notes" id="Notes" class="form-control" placeholder="" style="height: 100px;">{{ old('Notes', $heritage->Notes) }}</textarea>
                            <label for="Notes">Observações Adicionais</label>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-primary"><i class="fas fa-check-circle me-1"></i> Atualizar Património</button>
                    <a href="{{ route('heritages.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
