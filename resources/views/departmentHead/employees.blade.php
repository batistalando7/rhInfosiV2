@extends('layouts.admin.layout')
@section('title', 'Funcionários do Meu Departamento')
@section('content')

<div class="card mt-4 mt-4 shadow-lg border-0">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center rounded-top">
    <h5 class="mb-0"><i class="fas fa-building me-3"></i>Funcionários do Meu Departamento</h5>
    <a href="{{ route('dh.pendingVacations') }}" class="btn btn-outline-light btn-sm">
      <i class="fas fa-clock me-2"></i>Férias Pendentes
    </a>
  </div>

  <div class="card-body p-4">
    <div class="row justify-content-center">
      <div class="col-lg-9 col-xl-8">

        <div class="table-responsive rounded-3 shadow-sm">
          <table class="table table-hover align-middle mb-0">
            <thead class="bg-secondary text-white">
              <tr>
                <th class="ps-4">ID</th>
                <th>Funcionário</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              @forelse($employees as $emp)
                <tr class="border-bottom">
                  <td class="ps-4 text-muted">#{{ $emp->id }}</td>
                  <td class="py-3">
                    <div class="d-flex align-items-center">
                      @if($emp->photo)
                        <img src="{{ asset('frontend/images/departments/' . $emp->photo) }}"
                             alt="{{ $emp->fullName }}"
                             class="rounded-circle me-3 shadow-sm"
                             style="width: 45px; height: 45px; object-fit: cover;">
                      @else
                        <div class="bg-light rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm"
                             style="width: 45px; height: 45px;">
                          <i class="fas fa-user text-muted fs-4"></i>
                        </div>
                      @endif
                      <strong>{{ $emp->fullName }}</strong>
                    </div>
                  </td>
                  <td>
                    <a href="mailto:{{ $emp->email }}" class="text-decoration-none">
                      {{ $emp->email }}
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="text-center py-5">
                    <i class="fas fa-inbox text-muted fs-1 mb-3 d-block"></i>
                    <p class="text-muted fs-5 mb-0">Nenhum funcionário registado no seu departamento.</p>
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