@extends('layouts.admin.layout')
@section('title', $type == 'in' ? 'Registrar Entrada de Material' : 'Registrar Saída de Material')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-exchange-alt me-2"></i> {{ $type == 'in' ? 'Entrada de Material' : 'Saída de Material' }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route("materials.transactions.{$type}.store") }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select name="MaterialId" id="MaterialId" class="form-select" required>
                                <option value="">-- selecione material --</option>
                                @foreach ($materials as $m)
                                    <option value="{{ $m->id }}" {{ old('MaterialId') == $m->id ? 'selected' : '' }}>
                                        {{ $m->Name }} ({{ $m->type->name }}) — Estoque: {{ $m->CurrentStock }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="MaterialId">Material</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-floating">
                            <input type="date" name="TransactionDate" id="TransactionDate" class="form-control"
                                placeholder="" value="{{ old('TransactionDate', now()->toDateString()) }}" required>
                            <label for="TransactionDate">Data</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-floating">
                            <input type="number" name="Quantity" id="Quantity" class="form-control" placeholder=""
                                min="1" value="{{ old('Quantity') }}" required>
                            <label for="Quantity">Quantidade</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="OriginOrDestination" id="OriginOrDestination" class="form-control"
                                placeholder="" value="{{ old('OriginOrDestination') }}" required>
                            <label for="OriginOrDestination">{{ $type == 'in' ? 'Origem' : 'Destino' }}</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="file" name="DocumentationPath" id="DocumentationPath" class="form-control"
                                placeholder="">
                            <label for="DocumentationPath">Documento (opcional)</label>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            <textarea name="Notes" id="Notes" class="form-control" placeholder="" style="height: 100px;">{{ old('Notes') }}</textarea>
                            <label for="Notes">Observações</label>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button class="btn btn-{{ $type == 'in' ? 'success' : 'danger' }}">
                        <i class="fas fa-check-circle me-1"></i> {{ $type == 'in' ? 'Confirmar Entrada' : 'Confirmar Saída' }}
                    </button>
                    <a href="{{ route('materials.transactions.index') }}" class="btn btn-secondary ms-2">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
