<!-- Viatura -->
<h5 class="mb-3">Informações da Viatura</h5>
<div class="row g-3 mb-3">
    <div class="col-md-12">
        <div class="form-floating">
            <select name="vehicleId" id="vehicleId" class="form-select" required onchange="loadVehicleDetails(this.value)">
                <option value="">Selecione a Viatura</option>
                @foreach ($vehicles as $v)
                    <option value="{{ $v->id }}" data-brand="{{ $v->brand }}" data-model="{{ $v->model }}"
                        data-year="{{ $v->yearManufacture }}" data-plate="{{ $v->plate }}">
                        {{ $v->plate }} - {{ $v->brand }} {{ $v->model }}
                    </option>
                @endforeach
            </select>
            <label for="vehicleId">Viatura</label>
        </div>
    </div>
</div>
<div id="vehicleDetails" class="row g-3 mb-3" style="display:none;">
    <div class="col-md-3"><strong>Marca:</strong> <span id="brand"></span></div>
    <div class="col-md-3"><strong>Modelo:</strong> <span id="model"></span></div>
    <div class="col-md-3"><strong>Ano:</strong> <span id="year"></span></div>
    <div class="col-md-3"><strong>Placa:</strong> <span id="plate"></span></div>
</div>

<!-- Tipo de Manutenção -->
<h5 class="mb-3">Tipo de Manutenção</h5>
<div class="row g-3 mb-3">
    <div class="col-md-12">
        <div class="form-floating">
            <select name="type" id="type" class="form-select" required onchange="toggleSubtypes(this.value)">
                <option value="">Selecione o Tipo</option>
                <option value="Preventive">Preventiva</option>
                <option value="Corrective">Corretiva</option>
                <option value="Repair">Reparo</option>
            </select>
            <label for="type">Tipo Principal</label>
        </div>
    </div>
    {{-- <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="subType" class="form-control" value="{{ old('subType') }}" placeholder="">
                        <label for="subType">Subtipo Ex: Verificação do Óleo </label>
                    </div>
                </div> --}}
</div>

<!-- Serviços -->
<div id="subtypesSection" style="display:none;">
    <h6>Selecione Serviços Realizados:</h6>
    <div class="row g-2">
        <div id="preventive" style="display:none;">
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[troca_oleo]" value="troca_oleo"
                    onchange="toggleServiceDetails('troca_oleo', this.checked)"> Troca de
                Óleo
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[troca_filtro_ar]"
                    value="troca_filtro_ar" onchange="toggleServiceDetails('troca_filtro_ar', this.checked)"> Troca
                Filtro Ar
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[troca_filtro_oleo]"
                    value="troca_filtro_oleo" onchange="toggleServiceDetails('troca_filtro_oleo', this.checked)"> Troca
                Filtro Óleo
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[verificacao_pneus]"
                    value="verificacao_pneus"> Verificação Pneus
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[verificacao_liquidos]"
                    value="verificacao_liquidos"> Verificação Líquidos
            </div>
        </div>
        <div id="corrective" style="display:none;">
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[troca_pastilhas]"
                    value="troca_pastilhas" onchange="toggleServiceDetails('troca_pastilhas', this.checked)"> Troca
                Pastilhas Freio
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[troca_discos]"
                    value="troca_discos" onchange="toggleServiceDetails('troca_discos', this.checked)">
                Troca Discos Freio
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[troca_bateria]"
                    value="troca_bateria"> Troca Bateria
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[troca_pneus]"
                    value="troca_pneus"> Troca Pneus
            </div>
        </div>
        <div id="repair" style="display:none;">
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[reparo_motor]"
                    value="reparo_motor"> Reparo Motor
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[reparo_transmissao]"
                    value="reparo_transmissao"> Reparo Transmissão
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[reparo_suspensao]"
                    value="reparo_suspensao"> Reparo Suspensão
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input services" name="services[reparo_freios]"
                    value="reparo_freios"> Reparo Freios
            </div>
        </div>
        <div class="col-md-12 form-check">
            <input type="checkbox" class="form-check-input" name="services[outros]" value="outros"
                onchange="toggleOtherServices(this.checked)"> Outros
        </div>
    </div>

    <div id="serviceDetails" class="mt-3"></div>

    <div id="otherServices" class="mt-3" style="display:none;">
        <div class="form-floating">
            <textarea name="services[outros_details]" class="form-control" style="height: 80px"></textarea>
            <label>Outros Detalhes</label>
        </div>
    </div>
</div>

<h5 class="mb-3">Outras Informações</h5>
<!-- Dados da Manutenção -->
<div class="row g-3 mt-3">
    <div class="col-md-4">
        <div class="form-floating">
            <input type="date" name="date" class="form-control" value="{{ old('date') }}" required
                max="{{ date('Y-m-d') }}">
            <label>Data da Manutenção</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-floating">
            <input type="number" name="mileageNow" class="form-control" value="{{ old('mileageNow') }}" required
                min="0" step="0.01">
            <label>Quilometragem Atual (km)</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-floating">
            <input type="number" name="cost" class="form-control" value="{{ old('cost') }}" required
                min="0" step="0.01">
            <label>Custo (Kz)</label>
        </div>
    </div>
    {{-- <div class="col-md-3">
                    <div class="form-floating">
                        <input type="date" name="nextMaintenanceDate" class="form-control" value="{{ old('nextMaintenanceDate') }}">
                        <label>Próxima Data</label>
                    </div>
                </div> --}}
    {{-- <div class="col-md-3">
                        <div class="form-floating">
                            <input type="number" name="nextMileage" class="form-control"
                                value="{{ old('nextMileage') }}" min="0" step="0.01">
                            <label>Próxima Quilometragem (km)</label>
                        </div>
                    </div> --}}

    <div class="row g-3 mt-2">
    </div>
    <div class="col-md-12">
        <h5 class="mb-3">Descrição</h5>
        <div class="form-floating">
            {{-- <textarea name="d" id="editor"></textarea> --}}
            <textarea name="description" id="editor" >{{ old('description') }}</textarea>
            {{-- <label>Descrição</label> --}}
        </div>
    </div>
</div>

{{-- <div class="row g-3 mt-2">
                <div class="col-md-12">
                    <div class="form-floating">
                        <textarea name="piecesReplaced" class="form-control" style="height: 60px">{{ old('piecesReplaced') }}</textarea>
                        <label>Peças Substituídas</label>
                    </div>
                </div>
            </div> --}}

<!-- Responsável -->
<h5 class="mb-3 mt-4">Responsável</h5>
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" name="responsibleName" class="form-control" value="{{ old('responsibleName') }}"
                required maxlength="100">
            <label>Nome</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-floating">
            <input type="tel" name="responsiblePhone" class="form-control"
                value="{{ old('responsiblePhone') }}" maxlength="20">
            <label>Telefone</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-floating">
            <input type="email" name="responsibleEmail" class="form-control"
                value="{{ old('responsibleEmail') }}">
            <label>Email</label>
        </div>
    </div>
</div>

{{-- <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <textarea name="observations" class="form-control" style="height: 80px">{{ old('observations') }}</textarea>
                        <label>Observações</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="file" name="invoice_pre" class="form-control" accept=".pdf,.jpg,.png">
                        <label>Fatura Prévia</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="file" name="invoice_post" class="form-control" accept=".pdf,.jpg,.png">
                        <label>Fatura Concluída</label>
                    </div>
                </div>
            </div> --}}

<div class="d-grid gap-2 col-md-4 mx-auto mt-4">
    <button type="submit" class="btn btn-primary btn-lg">
        <i class="fas fa-save me-2"></i>Salvar
    </button>
</div>
