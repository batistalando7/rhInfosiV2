@extends('layouts.admin.layout')
@section('title', 'Registrar Manutenção')

@section('content')
<div class="card">
    <div class="card-header bg-info text-white">
        <h4><i class="fas fa-tools"></i> Registrar Histórico de Manutenção</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('heritage.maintenance.store', $heritage->id) }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Data da Manutenção</label>
                    <input type="date" name="MaintenanceDate" class="form-control" required>
                </div>
                <div class="col-12">
                    <label>Descrição da Manutenção</label>
                    <textarea name="MaintenanceDescription" class="form-control" rows="4" required></textarea>
                </div>
                <div class="col-md-6">
                    <label>Responsável pela Manutenção</label>
                    <input type="text" name="MaintenanceResponsible" class="form-control" required value="{{ Auth::user()->name ?? Auth::user()->email }}">
                </div>
            </div>
            <div class="mt-4 text-center">
                <button class="btn btn-info btn-lg">Registrar Manutenção</button>
                <a href="{{ route('heritage.show', $heritage->id) }}" class="btn btn-secondary btn-lg">Voltar</a>
            </div>
        </form>
    </div>
</div>
@endsection