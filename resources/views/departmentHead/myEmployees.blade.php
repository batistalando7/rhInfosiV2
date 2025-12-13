@extends('layouts.admin.layout')
@section('title', 'Meus Funcionários')
@section('content')

@php
    $departmentHead = auth()->user()->employee;
@endphp

<div class="card mb-4 mt-4 shadow-lg border-0">
  <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top">
    <h5 class="mb-0"><i class="fas fa-users me-3"></i>Meus Funcionários</h5>
    <a href="{{ route('dh.pendingVacations') }}" class="btn btn-outline-light btn-sm">
      <i class="fas fa-umbrella-beach me-2"></i>Férias Pendentes
    </a>
  </div>

  <div class="card-body p-4">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-9">

        <!-- Informações do Chefe -->
        <div class="alert alert-info border-0 rounded-3 text-center py-3 mb-4 shadow-sm">
          <i class="fas fa-user-tie fa-2x mb-2 text-primary d-block"></i>
          <strong class="fs-5">Chefe de Departamento:</strong><br>
          <span class="fs-4">{{ $departmentHead->fullName ?? 'Não definido' }}</span>
        </div>

        <!-- Tabela de Funcionários -->
        <div class="table-responsive rounded-3 shadow-sm">
          <table class="table table-hover align-middle mb-0">
            <thead class="bg-primary text-white">
              <tr>
                <th class="ps-4">Funcionário</th>
                <th>Posição / Cargo</th>
                <th class="text-center">Documentos</th>
              </tr>
            </thead>
            <tbody>
              @forelse($employees as $emp)
                <tr class="border-bottom">
                  <td class="ps-4 py-3">
                    <div class="d-flex align-items-center">
                      @if($emp->photo)
                        <img src="{{ asset('frontend/images/departments/' . $emp->photo) }}"
                             alt="{{ $emp->fullName }}"
                             class="rounded-circle me-3 shadow-sm"
                             style="width: 50px; height: 50px; object-fit: cover;">
                      @else
                        <div class="bg-light rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm"
                             style="width: 50px; height: 50px;">
                          <i class="fas fa-user text-muted fs-3"></i>
                        </div>
                      @endif
                      <div>
                        <strong class="d-block">{{ $emp->fullName }}</strong>
                        <small class="text-muted">{{ $emp->email }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    @if($emp->position)
                      <span class="badge bg-success rounded-pill px-3 py-2">
                        {{ $emp->position->name }}
                      </span>
                    @else
                      <span class="text-muted">—</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <a href="{{ route('dh.downloadEmployeeVacationPdf', $emp->id) }}"
                         class="btn btn-outline-primary btn-sm rounded-start"
                         title="PDF de Férias"
                         target="_blank">
                        <i class="fas fa-umbrella-beach me-1"></i>Férias
                      </a>
                      <a href="{{ route('dh.downloadEmployeeLeavePdf', $emp->id) }}"
                         class="btn btn-outline-secondary btn-sm rounded-end"
                         title="PDF de Licença"
                         target="_blank">
                        <i class="fas fa-file-medical me-1"></i>Licença
                      </a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="text-center py-5">
                    <i class="fas fa-users-slash text-muted fs-1 mb-3 d-block"></i>
                    <p class="text-muted fs-5 mb-0">Nenhum funcionário encontrado no seu departamento.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection
