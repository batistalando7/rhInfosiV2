@extends('layouts.admin.layout')
@section('title', 'Editar Manutenção')
@section('content')
<div class="card my-4 shadow">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-tools me-2"></i>Editar Manutenção #{{ $maintenance->id }}</span>
        <a href="{{ route('maintenance.index') }}" class="btn btn-outline-light btn-sm">
            <i class="fa-solid fa-list"></i>
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('maintenance.update', $maintenance->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <h5 class="mb-3">Informações da Viatura</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <select name="vehicleId" id="vehicleId" class="form-select" required onchange="loadVehicleDetails(this.value)">
                            <option value="">Selecione a Viatura</option>
                            @foreach ($vehicles as $v)
                                <option value="{{ $v->id }}" 
                                    data-brand="{{ $v->brand }}" 
                                    data-model="{{ $v->model }}" 
                                    data-year="{{ $v->yearManufacture }}" 
                                    data-plate="{{ $v->plate }}" 
                                    {{ old('vehicleId', $maintenance->vehicleId) == $v->id ? 'selected' : '' }}>
                                    {{ $v->plate }} - {{ $v->brand }} {{ $v->model }}
                                </option>
                            @endforeach
                        </select>
                        <label for="vehicleId">Viatura</label>
                    </div>
                </div>
            </div>
            <div id="vehicleDetails" class="row g-3 mb-3" style="display: {{ old('vehicleId', $maintenance->vehicleId) ? 'flex' : 'none' }};">
                <div class="col-md-3"><strong>Marca:</strong> <span id="brand">{{ $maintenance->vehicle->brand ?? '' }}</span></div>
                <div class="col-md-3"><strong>Modelo:</strong> <span id="model">{{ $maintenance->vehicle->model ?? '' }}</span></div>
                <div class="col-md-3"><strong>Ano:</strong> <span id="year">{{ $maintenance->vehicle->yearManufacture ?? '' }}</span></div>
                <div class="col-md-3"><strong>Placa:</strong> <span id="plate">{{ $maintenance->vehicle->plate ?? '' }}</span></div>
            </div>
            <h5 class="mb-3">Tipo de Manutenção</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="type" id="type" class="form-select" required onchange="toggleSubtypes(this.value)">
                            <option value="">Selecione o Tipo</option>
                            <option value="Preventive" {{ old('type', $maintenance->type) == 'Preventive' ? 'selected' : '' }}>Preventiva</option>
                            <option value="Corrective" {{ old('type', $maintenance->type) == 'Corrective' ? 'selected' : '' }}>Corretiva</option>
                            <option value="Repair" {{ old('type', $maintenance->type) == 'Repair' ? 'selected' : '' }}>Reparo</option>
                        </select>
                        <label for="type">Tipo Principal</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="subType" class="form-control" value="{{ old('subType', $maintenance->subType) }}" placeholder="Ex: troca_oleo">
                        <label for="subType">Subtipo Específico</label>
                    </div>
                </div>
            </div>
            <div id="subtypesSection" style="display: {{ old('type', $maintenance->type) ? 'block' : 'none' }};">
                <h6>Selecione Serviços Realizados:</h6>
                <div class="row g-2">
                    <!-- PREVENTIVA -->
                    <div id="preventive" style="display: {{ old('type', $maintenance->type) == 'Preventive' ? 'block' : 'none' }};">
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_oleo]" value="troca_oleo" {{ array_key_exists('troca_oleo', old('services', $maintenance->services ?? [])) ? 'checked' : '' }} onchange="toggleServiceDetails('troca_oleo', this.checked)">
                            Troca de Óleo
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_filtro_ar]" value="troca_filtro_ar" {{ array_key_exists('troca_filtro_ar', old('services', $maintenance->services ?? [])) ? 'checked' : '' }} onchange="toggleServiceDetails('troca_filtro_ar', this.checked)">
                            Troca Filtro Ar
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_filtro_oleo]" value="troca_filtro_oleo" {{ array_key_exists('troca_filtro_oleo', old('services', $maintenance->services ?? [])) ? 'checked' : '' }} onchange="toggleServiceDetails('troca_filtro_oleo', this.checked)">
                            Troca Filtro Óleo
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[verificacao_pneus]" value="verificacao_pneus" {{ array_key_exists('verificacao_pneus', old('services', $maintenance->services ?? [])) ? 'checked' : '' }}>
                            Verificação Pneus
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[verificacao_liquidos]" value="verificação_liquidos" {{ array_key_exists('verificação_liquidos', old('services', $maintenance->services ?? [])) ? 'checked' : '' }}>
                            Verificação Líquidos
                        </div>
                    </div>
                    <!-- CORRETIVA -->
                    <div id="corrective" style="display: {{ old('type', $maintenance->type) == 'Corrective' ? 'block' : 'none' }};">
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_pastilhas]" value="troca_pastilhas" {{ array_key_exists('troca_pastilhas', old('services', $maintenance->services ?? [])) ? 'checked' : '' }} onchange="toggleServiceDetails('troca_pastilhas', this.checked)">
                            Troca Pastilhas Freio
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_discos]" value="troca_discos" {{ array_key_exists('troca_discos', old('services', $maintenance->services ?? [])) ? 'checked' : '' }} onchange="toggleServiceDetails('troca_discos', this.checked)">
                            Troca Discos Freio
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_bateria]" value="troca_bateria" {{ array_key_exists('troca_bateria', old('services', $maintenance->services ?? [])) ? 'checked' : '' }}>
                            Troca Bateria
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[troca_pneus]" value="troca_pneus" {{ array_key_exists('troca_pneus', old('services', $maintenance->services ?? [])) ? 'checked' : '' }}>
                            Troca Pneus
                        </div>
                    </div>
                    <!-- REPARO -->
                    <div id="repair" style="display: {{ old('type', $maintenance->type) == 'Repair' ? 'block' : 'none' }};">
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[reparo_motor]" value="reparo_motor" {{ array_key_exists('reparo_motor', old('services', $maintenance->services ?? [])) ? 'checked' : '' }}>
                            Reparo Motor
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[reparo_transmissao]" value="reparo_transmissao" {{ array_key_exists('reparo_transmissao', old('services', $maintenance->services ?? [])) ? 'checked' : '' }}>
                            Reparo Transmissão
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[reparo_suspensao]" value="reparo_suspensao" {{ array_key_exists('reparo_suspensao', old('services', $maintenance->services ?? [])) ? 'checked' : '' }}>
                            Reparo Suspensão
                        </div>
                        <div class="col-md-3 form-check">
                            <input type="checkbox" class="form-check-input services" name="services[reparo_freios]" value="reparo_freios" {{ array_key_exists('reparo_freios', old('services', $maintenance->services ?? []) ) ? 'checked' : '' }}>
                            Reparo Freios
                        </div>
                    </div>
                    <div class="col-md-12 form-check">
                        <input type="checkbox" class="form-check-input" name="services[outros]" value="outros" {{ array_key_exists('outros', old('services', $maintenance->services ?? []) ) ? 'checked' : '' }} onchange="toggleOtherServices(this.checked)">
                        Outros
                    </div>
                </div>
                <div id="serviceDetails" class="mt-3">
                    @if ($maintenance->services && is_array($maintenance->services))
                        @foreach ($maintenance->services as $key => $details)
                            @if ($key == 'troca_oleo' && is_array($details))
                                <div class="row g-3 mt-2">
                                    <div class="col-md-6">
                                        <input type="text" name="services[troca_oleo][tipo]" value="{{ $details['tipo'] ?? '' }}" placeholder="Tipo de Óleo" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="services[troca_oleo][quantidade]" value="{{ $details['quantidade'] ?? '' }}" placeholder="Quantidade" class="form-control">
                                    </div>
                                </div>
                            @elseif ($key == 'troca_filtro_ar' && is_array($details))
                                <div class="mt-2">
                                    <input type="text" name="services[troca_filtro_ar][tipo]" value="{{ $details['tipo'] ?? '' }}" placeholder="Tipo de Filtro" class="form-control">
                                </div>
                            @elseif ($key == 'troca_filtro_oleo' && is_array($details))
                                <div class="mt-2">
                                    <input type="text" name="services[troca_filtro_oleo][tipo]" value="{{ $details['tipo'] ?? '' }}" placeholder="Tipo de Filtro" class="form-control">
                                </div>
                            @elseif ($key == 'troca_pastilhas' && is_array($details))
                                <div class="mt-2">
                                    <input type="text" name="services[troca_pastilhas][tipo]" value="{{ $details['tipo'] ?? '' }}" placeholder="Tipo de Pastilhas" class="form-control">
                                </div>
                            @elseif ($key == 'troca_discos' && is_array($details))
                                <div class="mt-2">
                                    <input type="text" name="services[troca_discos][tipo]" value="{{ $details['tipo'] ?? '' }}" placeholder="Tipo de Discos" class="form-control">
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div id="otherServices" class="mt-3" style="display: {{ array_key_exists('outros', old('services', $maintenance->services ?? []) ) ? 'block' : 'none' }};">
                    <div class="form-floating">
                        <textarea name="services[outros_details]" class="form-control" placeholder="Descreva outros serviços" style="height: 80px">{{ old('services.outros_details', $maintenance->services['outros_details'] ?? '') }}</textarea>
                        <label for="outros_details">Outros Detalhes</label>
                    </div>
                </div>
            </div>

            <!-- DADOS DA MANUTENÇÃO -->
            <div class="row g-3 mt-3">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="date" name="maintenanceDate" class="form-control" value="{{ old('maintenanceDate', $maintenance->maintenanceDate) }}" required max="{{ date('Y-m-d') }}">
                        <label for="maintenanceDate">Data da Manutenção</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="number" name="mileage" class="form-control" value="{{ old('mileage', $maintenance->mileage) }}" required min="0" step="0.01">
                        <label for="mileage">Quilometragem Atual (km)</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="number" name="cost" class="form-control" value="{{ old('cost', $maintenance->cost) }}" required min="0" step="0.01">
                        <label for="cost">Custo (Kwanza - Kz)</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="date" name="nextMaintenanceDate" class="form-control" value="{{ old('nextMaintenanceDate', $maintenance->nextMaintenanceDate) }}">
                        <label for="nextMaintenanceDate">Próxima Data de Manutenção</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" name="nextMileage" class="form-control" value="{{ old('nextMileage', $maintenance->nextMileage) }}" min="0" step="0.01">
                        <label for="nextMileage">Próxima Quilometragem (km)</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <textarea name="description" class="form-control" style="height: 80px">{{ old('description', $maintenance->description) }}</textarea>
                        <label for="description">Descrição da Manutenção</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-12">
                    <div class="form-floating">
                        <textarea name="piecesReplaced" class="form-control" style="height: 60px">{{ old('piecesReplaced', $maintenance->piecesReplaced) }}</textarea>
                        <label for="piecesReplaced">Peças Substituídas</label>
                    </div>
                </div>
            </div>

            <h5 class="mb-3 mt-4">Responsável pela Manutenção</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" name="responsibleName" class="form-control" value="{{ old('responsibleName', $maintenance->responsibleName) }}" required maxlength="100">
                        <label for="responsibleName">Nome</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="tel" name="responsiblePhone" class="form-control" value="{{ old('responsiblePhone', $maintenance->responsiblePhone) }}" maxlength="20">
                        <label for="responsiblePhone">Telefone</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="email" name="responsibleEmail" class="form-control" value="{{ old('responsibleEmail', $maintenance->responsibleEmail) }}">
                        <label for="responsibleEmail">Email</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <textarea name="observations" class="form-control" style="height: 80px">{{ old('observations', $maintenance->observations) }}</textarea>
                        <label for="observations">Observações Adicionais</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="file" name="invoice_pre" class="form-control" accept=".pdf,.jpg,.png">
                        <label for="invoice_pre">Fatura Prévia</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="file" name="invoice_post" class="form-control" accept=".pdf,.jpg,.png">
                        <label for="invoice_post">Fatura Concluída</label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-check-circle me-2"></i>Atualizar Manutenção
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function loadVehicleDetails(vehicleId) {
    const select = document.getElementById('vehicleId');
    const option = select.options[select.selectedIndex];
    if (vehicleId) {
        document.getElementById('brand').textContent = option.dataset.brand;
        document.getElementById('model').textContent = option.dataset.model;
        document.getElementById('year').textContent = option.dataset.year;
        document.getElementById('plate').textContent = option.dataset.plate;
        document.getElementById('vehicleDetails').style.display = 'flex';
    } else {
        document.getElementById('vehicleDetails').style.display = 'none';
    }
}
function toggleSubtypes(type) {
    document.getElementById('subtypesSection').style.display = 'block';
    ['preventive', 'corrective', 'repair'].forEach(id => document.getElementById(id).style.display = 'none');
    if (type === 'Preventive') document.getElementById('preventive').style.display = 'block';
    else if (type === 'Corrective') document.getElementById('corrective').style.display = 'block';
    else if (type === 'Repair') document.getElementById('repair').style.display = 'block';
}
function toggleServiceDetails(service, checked) {
    const detailsDiv = document.getElementById('serviceDetails');
    let html = '';
    if (checked) {
        if (service === 'troca_oleo') {
            html = '<div class="row g-3 mt-2"><div class="col-md-6"><input type="text" name="services[troca_oleo][tipo]" placeholder="Tipo de Óleo" class="form-control"></div><div class="col-md-6"><input type="text" name="services[troca_oleo][quantidade]" placeholder="Quantidade" class="form-control"></div></div>';
        } else if (service === 'troca_filtro_ar') {
            html = '<div class="mt-2"><input type="text" name="services[troca_filtro_ar][tipo]" placeholder="Tipo de Filtro" class="form-control"></div>';
        } else if (service === 'troca_filtro_oleo') {
            html = '<div class="mt-2"><input type="text" name="services[troca_filtro_oleo][tipo]" placeholder="Tipo de Filtro" class="form-control"></div>';
        } else if (service === 'troca_pastilhas') {
            html = '<div class="mt-2"><input type="text" name="services[troca_pastilhas][tipo]" placeholder="Tipo de Pastilhas" class="form-control"></div>';
        } else if (service === 'troca_discos') {
            html = '<div class="mt-2"><input type="text" name="services[troca_discos][tipo]" placeholder="Tipo de Discos" class="form-control"></div>';
        }
        detailsDiv.innerHTML += html;
    }
}
function toggleOtherServices(checked) {
    document.getElementById('otherServices').style.display = checked ? 'block' : 'none';
}
</script>
@endsection