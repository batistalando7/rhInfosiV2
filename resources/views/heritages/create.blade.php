@extends('layouts.admin.layout')
@section('title', 'Novo Património')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-plus-circle me-2"></i> Cadastrar Novo Património
        </div>
        <div class="card-body">
            {{-- Adicionado enctype="multipart/form-data" --}}
            <form action="{{ route('heritages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- Informações do Património --}}
                    <h5 class="mb-3 text-primary">1. Informações do Património</h5>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select name="heritageTypeId" id="heritageTypeId" class="form-select" required>
                                <option value="">-- selecione --</option>
                                @foreach ($types as $t)
                                    <option value="{{ $t->id }}" {{ old('heritageTypeId') == $t->id ? 'selected' : '' }}>
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
                                value="{{ old('Description') }}" required>
                            <label for="Description">Descrição do Património</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="number" step="0.01" name="Value" id="Value" class="form-control" placeholder=""
                                value="{{ old('Value') }}" required>
                            <label for="Value">Valor do Património (Kz)</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="date" name="AcquisitionDate" id="AcquisitionDate" class="form-control" placeholder=""
                                value="{{ old('AcquisitionDate') }}" required>
                            <label for="AcquisitionDate">Data de Aquisição</label>
                        </div>
                    </div>
                    {{-- Novo Campo de Upload --}}
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="file" name="DocumentationPath" id="DocumentationPath" class="form-control" placeholder="">
                            <label for="DocumentationPath">Documento de Aquisição (PDF, Imagem)</label>
                        </div>
                    </div>

                    {{-- Localização e Responsável --}}
                    <h5 class="mb-3 mt-3 text-primary">2. Localização e Responsável Atual</h5>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="Location" id="Location" class="form-control" placeholder=""
                                value="{{ old('Location') }}" required>
                            <label for="Location">Localização Atual</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="ResponsibleName" id="ResponsibleName" class="form-control" placeholder=""
                                value="{{ old('ResponsibleName') }}" required>
                            <label for="ResponsibleName">Nome do Responsável Atual</label>
                        </div>
                    </div>

                    {{-- Estado e Observações --}}
                    <h5 class="mb-3 mt-3 text-primary">3. Estado e Observações</h5>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select name="Condition" id="Condition" class="form-select" required>
                                <option value="">-- selecione --</option>
                                @foreach (['Novo', 'Usado', 'Danificado', 'Em Manutenção', 'Avariado'] as $condition)
                                    <option value="{{ $condition }}" {{ old('Condition') == $condition ? 'selected' : '' }}>
                                        {{ $condition }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="Condition">Condição</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <textarea name="Notes" id="Notes" class="form-control" placeholder="" style="height: 100px;">{{ old('Notes') }}</textarea>
                            <label for="Notes">Observações Adicionais</label>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-success"><i class="fas fa-check-circle me-1"></i> Salvar Património</button>
                    <a href="{{ route('heritages.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
