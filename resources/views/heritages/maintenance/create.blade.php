@extends('layouts.admin.layout')
@section('title', 'Registar Manutenção')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-info text-white">
            <i class="fas fa-wrench me-2"></i> Registar Manutenção para: **{{ $heritage->Description }}**
        </div>
        <div class="card-body">
            <form action="{{ route('heritages.storeMaintenance', $heritage->id) }}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h5 class="mb-3 text-info">Informações da Manutenção</h5>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="date" name="MaintenanceDate" id="MaintenanceDate" class="form-control" placeholder=""
                                    value="{{ old('MaintenanceDate', now()->toDateString()) }}" required>
                                <label for="MaintenanceDate">Data da Manutenção</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="number" step="0.01" name="MaintenanceCost" id="MaintenanceCost" class="form-control" placeholder=""
                                    value="{{ old('MaintenanceCost') }}">
                                <label for="MaintenanceCost">Custo da Manutenção (Kz) (Opcional)</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea name="Description" id="Description" class="form-control" placeholder="" style="height: 100px;" required>{{ old('Description') }}</textarea>
                                <label for="Description">Descrição Detalhada da Manutenção</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="ResponsibleName" id="ResponsibleName" class="form-control" placeholder=""
                                    value="{{ old('ResponsibleName') }}" required>
                                <label for="ResponsibleName">Nome do Responsável pela Manutenção</label>
                            </div>
                        </div>
                           <div class="d-grid gap-2 col-4 mx-auto mt-4">
                            <button class="btn btn-info text-white"><i class="fas fa-save me-1"></i> Salvar Manutenção</button>
                            <a href="{{ route('heritages.show', $heritage->id) }}" class="btn btn-secondary ms-2">Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
