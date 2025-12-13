@extends('layouts.admin.layout')
@section('title', 'Editar Manutenção')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-info text-white">
            <i class="fas fa-pencil me-2"></i> Editar Manutenção para: **{{ $heritage->Description }}**
        </div>
        <div class="card-body">
            <form action="{{ route('heritages.maintenance.update', ['heritage' => $heritage->id, 'maintenance' => $maintenance->id]) }}" method="POST">
                @csrf @method('PUT')
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h5 class="mb-3 text-info">Informações da Manutenção</h5>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="date" name="MaintenanceDate" id="MaintenanceDate" class="form-control" placeholder=""
                                    value="{{ old('MaintenanceDate', $maintenance->MaintenanceDate->format('Y-m-d')) }}" required>
                                <label for="MaintenanceDate">Data da Manutenção</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="number" step="0.01" name="MaintenanceCost" id="MaintenanceCost" class="form-control" placeholder=""
                                    value="{{ old('MaintenanceCost', $maintenance->MaintenanceCost) }}">
                                <label for="MaintenanceCost">Custo da Manutenção (MZN) (Opcional)</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea name="Description" id="Description" class="form-control" placeholder="" style="height: 100px;" required>{{ old('Description', $maintenance->Description) }}</textarea>
                                <label for="Description">Descrição Detalhada da Manutenção</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <select name="ResponsibleEmployeeId" id="ResponsibleEmployeeId" class="form-select">
                                    <option value="">-- selecione (opcional) --</option>
                                    @foreach ($employees as $e)
                                        <option value="{{ $e->id }}" {{ old('ResponsibleEmployeeId', $maintenance->ResponsibleEmployeeId) == $e->id ? 'selected' : '' }}>
                                            {{ $e->fullName }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="ResponsibleEmployeeId">Responsável pela Manutenção (Funcionário)</label>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn btn-primary"><i class="fas fa-check me-1"></i> Atualizar Manutenção</button>
                            <a href="{{ route('heritages.show', $heritage->id) }}" class="btn btn-secondary ms-2">Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
