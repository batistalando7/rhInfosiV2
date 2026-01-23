@extends('layouts.admin.layout')
@section('title', 'Filtrar Estagiários por Data')
@section('content')

    <div class="card my-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-calendar-event me-2"></i>Filtrar Estagiários por Data</span>
            <div>
                @if (isset($filtered))
                    <form action="{{ route('admin.intern.filter.pdf') }}" target="_blank" method="POST">
                        @csrf
                        <input type="hidden" name="start_date" value="{{ request('start_date', $start ?? '') }}">
                        <input type="hidden" name="end_date" value="{{ request('end_date', $end ?? '') }}">
                        <input type="hidden" name="departmentId" value="{{ request('departmentId', $selectedDepartment ?? '') }}">
                        <input type="hidden" name="specialityId" value="{{ request('specialityId', $selectedSpeciality ?? '') }}">
                        <button class="btn btn-outline-light btn-sm me-2">
                            <i class="fas fa-file-earmark-pdf"></i> Baixar PDF
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.intern.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.intern.filter') }}" method="GET" class="mb-4">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="start_date" class="form-control"
                                value="{{ old("start_date", request("start_date", $start ?? "")) }}">
                            <label for="start_date">Data Inicial</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="end_date" class="form-control"
                                value="{{ old("end_date", request("end_date", $end ?? "")) }}">
                            <label for="end_date">Data Final</label>
                        </div>
                    </div>
                    <!-- Especialidade -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="specialityId" class="form-select">
                                <option value="" selected>Todas as Especialidades</option>
                                @foreach ($speciality as $type)
                                    <option value="{{ $type->id }}"
                                        {{ request('specialityId', $selectedSpeciality ?? '') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="specialityId">Especialidade</label>
                        </div>
                    </div>
                    <!-- Departamento -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="departmentId" class="form-select">
                                <option value="" selected>Todos os departamentos</option>
                                @foreach ($departments as $type)
                                    <option value="{{ $type->id }}"
                                        {{ request('departmentId', $selectedDepartment ?? '') == $type->id ? 'selected' : '' }}>
                                        {{ $type->title }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="departmentId">Departamento</label>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div> --}}
                </div>
                <!-- Botão Filtrar -->
                <div class="col-md-3 m-auto mt-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>

            @isset($filtered)
                @if ($filtered->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome Completo</th>
                                    <th>Departamento</th>
                                    <th>Especialidade</th>
                                    <th>Data de Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filtered as $intern)
                                    <tr>
                                        <td>{{ $intern->id }}</td>
                                        <td>{{ $intern->fullName }}</td>
                                        <td>{{ $intern->department->title ?? '-' }}</td>
                                        <td>{{ $intern->specialty->name ?? '-' }}</td>
                                        <td>{{ $intern->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center mt-4">Nenhum estagiário encontrado neste período.</p>
                @endif
            @endisset

        </div>
    </div>

@endsection
