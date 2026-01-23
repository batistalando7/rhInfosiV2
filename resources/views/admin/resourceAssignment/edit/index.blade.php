@extends('layouts.admin.layout')
@section('title', 'Novo Pedido de Licença')
@section('content')
    <div class="row justify-content-center" style="margin-top: 1.5rem">
        <div class="{{ isset($employee) ? 'col-md-5' : 'col-md-8' }}">
            <div class="card mb-4 shadow">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-file-alt me-2"></i>Novo Pedido de Licença</span>
                    <a href="{{ route('leaveRequest.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
                <div class="card-body">

                    <hr>
                    <!-- Dados do Funcionário -->
                    <div class="mb-3">
                        <h5 class="mb-1">Dados do Funcionário</h5>
                        <p class="mb-0"><strong>Nome:</strong> {{ $resourceAssignment->employeee->fullName }}</p>
                        <p class="mb-0"><strong>Departamento:</strong>
                            {{ $resourceAssignment->employeee->department->title ?? ' -' }}</p>
                    </div>
                    <!-- Formulário de Pedido de Licença -->
                    <form method="POST" action="{{ route('admin.resourceAssignments.update', $resourceAssignment->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="employeeeId" value="{{ $resourceAssignment->employeee->id }}">

                        <div class="mb-3">
                            <div class="form-floating">
                                <select name="vehicleId" id="vehicleId" class="form-select" required>
                                    <option value="{{ $resourceAssignment->vehicle->id ?? '' }}">
                                        {{ $resourceAssignment->vehicle->brand . '-' . $resourceAssignment->vehicle->model ?? '-- Selecione o Veículo --' }}
                                    </option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                            {{ old('vehicleId') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->brand }} - {{ $vehicle->model }} - {{ $vehicle->plate }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="vehicleId">Tipo de Veículo</label>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ old('start_date', $resourceAssignment->start_date ?? '') }}" required>
                                    <label for="start_date">Data de Início</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ old('end_date', $resourceAssignment->end_date ?? '') }}" required>
                                    <label for="end_date">Data de Término</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mt-2">
                            <div class="form-floating">
                                <textarea name="reason" id="reason" placeholder="" style="height: 100px;" class="form-control">{{ old('reason', $resourceAssignment->notes ?? '') }}</textarea>
                                <label for="reason">Razão</label>
                            </div>
                        </div>
                        <div class="d-grid gap-2 col-4 mx-auto mt-4">
                            <button type="submit" class="btn btn-success">Salvar Pedido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
