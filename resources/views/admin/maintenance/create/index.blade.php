@extends('layouts.admin.layout')
@section('title', 'Nova Manutenção')
@section('content')
    {{-- start Dependências do Editor de Texto --}}
    <link rel="stylesheet" href="{{ url('ckeditor5/style.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/46.1.1/ckeditor5.css" crossorigin>
    {{-- end Dependências do Editor de Texto --}}

    <div class="card my-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-tools me-2"></i>Nova Manutenção</span>
            <a href="{{ route('admin.maintenances.index') }}" class="btn btn-outline-light btn-sm">
                <i class="fa-solid fa-list"></i>
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.maintenances.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('forms._formMaintenance.index')
            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/46.1.1/ckeditor5.umd.js" crossorigin></script>
    @include('extra._ckeditor.index')
    {{-- <script src="{{ url('ckeditor5/main.js') }}"></script> --}}
    <script>
        function loadVehicleDetails(id) {
            const opt = document.querySelector(`#vehicleId option[value="${id}"]`);
            if (opt) {
                document.getElementById('brand').textContent = opt.dataset.brand;
                document.getElementById('model').textContent = opt.dataset.model;
                document.getElementById('year').textContent = opt.dataset.year;
                document.getElementById('plate').textContent = opt.dataset.plate;
                document.getElementById('vehicleDetails').style.display = 'flex';
            } else {
                document.getElementById('vehicleDetails').style.display = 'none';
            }
        }

        function toggleSubtypes(type) {
            document.getElementById('subtypesSection').style.display = 'block';
            ['preventive', 'corrective', 'repair'].forEach(id => document.getElementById(id).style.display = 'none');
            if (type) document.getElementById(type.toLowerCase()).style.display = 'block';
        }

        function toggleServiceDetails(service, checked) {
            const container = document.getElementById('serviceDetails');
            const existing = document.getElementById(`detail-${service}`);
            if (checked && !existing) {
                let html = '';
                if (service === 'troca_oleo') {
                    html = `<div class="service-detail-row row g-3 mt-2" id="detail-${service}">
                <div class="col-md-5"><input type="text" name="services[${service}][tipo]" placeholder="Tipo de Óleo" class="form-control"></div>
                <div class="col-md-5"><input type="text" name="services[${service}][quantidade]" placeholder="Quantidade" class="form-control"></div>
                <div class="col-md-2"><button type="button" class="btn btn-sm btn-danger" onclick="removeDetail('${service}')">×</button></div>
            </div>`;
                } else {
                    html = `<div class="service-detail-row row g-3 mt-2" id="detail-${service}">
                <div class="col-md-10"><input type="text" name="services[${service}][tipo]" placeholder="Tipo" class="form-control"></div>
                <div class="col-md-2"><button type="button" class="btn btn-sm btn-danger" onclick="removeDetail('${service}')">×</button></div>
            </div>`;
                }
                container.insertAdjacentHTML('beforeend', html);
            } else if (!checked && existing) {
                existing.remove();
            }
        }

        function removeDetail(service) {
            const el = document.getElementById(`detail-${service}`);
            if (el) el.remove();
            const checkbox = document.querySelector(`input[name="services[${service}]"]`);
            if (checkbox) checkbox.checked = false;
        }

        function toggleOtherServices(checked) {
            document.getElementById('otherServices').style.display = checked ? 'block' : 'none';
        }
    </script>
@endsection
