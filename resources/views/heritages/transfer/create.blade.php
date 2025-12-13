@extends('layouts.admin.layout')
@section('title', 'Registar Transferência')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-warning text-dark">
            <i class="fas fa-exchange-alt me-2"></i> Registar Transferência para: **{{ $heritage->Description }}**
        </div>
        <div class="card-body">
            <form action="{{ route('heritages.storeTransfer', $heritage->id) }}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h5 class="mb-3 text-warning">Informações da Transferência</h5>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="date" name="TransferDate" id="TransferDate" class="form-control" placeholder=""
                                    value="{{ old('TransferDate', now()->toDateString()) }}" required>
                                <label for="TransferDate">Data da Transferência</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea name="Reason" id="Reason" class="form-control" placeholder="" style="height: 100px;" required>{{ old('Reason') }}</textarea>
                                <label for="Reason">Motivo da Transferência</label>
                            </div>
                        </div>
                        
                        <h5 class="mb-3 mt-4 text-warning">Localização e Responsáveis</h5>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="OriginLocation" id="OriginLocation" class="form-control" placeholder=""
                                    value="{{ old('OriginLocation', $heritage->Location) }}" required>
                                <label for="OriginLocation">Localização de Origem</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="DestinationLocation" id="DestinationLocation" class="form-control" placeholder=""
                                    value="{{ old('DestinationLocation') }}" required>
                                <label for="DestinationLocation">Localização de Destino</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="ResponsibleName" id="ResponsibleName" class="form-control" placeholder=""
                                    value="{{ old('ResponsibleName') }}" required>
                                <label for="ResponsibleName">Nome do Responsável pela Transferência (Quem Autorizou/Executou)</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="TransferredToName" id="TransferredToName" class="form-control" placeholder=""
                                    value="{{ old('TransferredToName') }}" required>
                                <label for="TransferredToName">Nome do Novo Responsável (Quem Recebeu)</label>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button class="btn btn-warning text-dark"><i class="fas fa-save me-1"></i> Salvar Transferência</button>
                            <a href="{{ route('heritages.show', $heritage->id) }}" class="btn btn-secondary ms-2">Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
