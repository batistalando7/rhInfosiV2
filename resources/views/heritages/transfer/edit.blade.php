@extends('layouts.admin.layout')
@section('title', 'Editar Transferência')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-warning text-dark">
            <i class="fas fa-pencil me-2"></i> Editar Transferência para: **{{ $heritage->Description }}**
        </div>
        <div class="card-body">
            <form action="{{ route('heritages.transfer.update', ['heritage' => $heritage->id, 'transfer' => $transfer->id]) }}" method="POST">
                @csrf @method('PUT')
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h5 class="mb-3 text-warning">Informações da Transferência</h5>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="date" name="TransferDate" id="TransferDate" class="form-control" placeholder=""
                                    value="{{ old('TransferDate', $transfer->TransferDate->format('Y-m-d')) }}" required>
                                <label for="TransferDate">Data da Transferência</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea name="Reason" id="Reason" class="form-control" placeholder="" style="height: 100px;" required>{{ old('Reason', $transfer->Reason) }}</textarea>
                                <label for="Reason">Motivo da Transferência</label>
                            </div>
                        </div>
                        
                        <h5 class="mb-3 mt-4 text-warning">Localização e Responsáveis</h5>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="OriginLocation" id="OriginLocation" class="form-control" placeholder=""
                                    value="{{ old('OriginLocation', $transfer->OriginLocation) }}" required>
                                <label for="OriginLocation">Localização de Origem</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="DestinationLocation" id="DestinationLocation" class="form-control" placeholder=""
                                    value="{{ old('DestinationLocation', $transfer->DestinationLocation) }}" required>
                                <label for="DestinationLocation">Localização de Destino</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <select name="ResponsibleEmployeeId" id="ResponsibleEmployeeId" class="form-select">
                                    <option value="">-- selecione (opcional) --</option>
                                    @foreach ($employees as $e)
                                        <option value="{{ $e->id }}" {{ old('ResponsibleEmployeeId', $transfer->ResponsibleEmployeeId) == $e->id ? 'selected' : '' }}>
                                            {{ $e->fullName }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="ResponsibleEmployeeId">Responsável pela Transferência (Quem Autorizou/Executou)</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <select name="TransferredToEmployeeId" id="TransferredToEmployeeId" class="form-select">
                                    <option value="">-- selecione (opcional) --</option>
                                    @foreach ($employees as $e)
                                        <option value="{{ $e->id }}" {{ old('TransferredToEmployeeId', $transfer->TransferredToEmployeeId) == $e->id ? 'selected' : '' }}>
                                            {{ $e->fullName }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="TransferredToEmployeeId">Novo Responsável (Quem Recebeu)</label>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button class="btn btn-primary"><i class="fas fa-check me-1"></i> Atualizar Transferência</button>
                            <a href="{{ route('heritages.show', $heritage->id) }}" class="btn btn-secondary ms-2">Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
