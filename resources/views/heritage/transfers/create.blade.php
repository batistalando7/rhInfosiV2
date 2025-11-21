@extends('layouts.admin.layout')
@section('title', 'Registrar Transferência')

@section('content')
<div class="card">
    <div class="card-header bg-purple text-white">
        <h4><i class="fas fa-exchange-alt"></i> Registrar Transferência de Propriedade</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('heritage.transfer.store', $heritage->id) }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Data da Transferência</label>
                    <input type="date" name="TransferDate" class="form-control" required>
                </div>
                <div class="col-12">
                    <label>Motivo da Transferência</label>
                    <textarea name="TransferReason" class="form-control" rows="4" required></textarea>
                </div>
                <div class="col-md-6">
                    <label>Responsável pela Transferência</label>
                    <input type="text" name="TransferResponsible" class="form-control" required value="{{ Auth::user()->name ?? Auth::user()->email }}">
                </div>
            </div>
            <div class="mt-4 text-center">
                <button class="btn btn-purple btn-lg">Registrar Transferência</button>
                <a href="{{ route('heritage.show', $heritage->id) }}" class="btn btn-secondary btn-lg">Voltar</a>
            </div>
        </form>
    </div>
</div>
@endsection