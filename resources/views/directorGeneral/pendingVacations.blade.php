@extends('layouts.admin.layout')
@section('title', 'Pedidos de Férias - Direção Geral')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Pedidos de Férias para Decisão Final (Diretor Geral)</h4>
  </div>
  <div class="card-body">

    @if(session('msg'))
      <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Funcionário</th>
            <th>Período</th>
            <th>Tipo</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pendingRequests as $req)
            <tr>
              <td>{{ $req->id }}</td>
              <td>{{ $req->employee->fullName ?? '-' }}</td>
              <td>
                {{ \Carbon\Carbon::parse($req->vacationStart)->format('d/m/Y') }} até 
                {{ \Carbon\Carbon::parse($req->vacationEnd)->format('d/m/Y') }}
              </td>
              <td>{{ $req->vacationType }}</td>
              <td><span class="badge bg-warning text-dark">{{ $req->approvalStatus }}</span></td>
              <td>
                <div class="d-flex">
                  {{-- Botão Aprovar --}}
                  <form action="{{ route('admin.director.approveVacation', $req->id) }}" method="POST" class="me-2">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Deseja aprovar e assinar este pedido?')">
                      <i class="fas fa-check"></i> Aprovar
                    </button>
                  </form>

                  {{-- Botão Rejeitar (Modal) --}}
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $req->id }}">
                    <i class="fas fa-times"></i> Rejeitar
                  </button>
                </div>

                <!-- Modal Rejeição -->
                <div class="modal fade" id="rejectModal-{{ $req->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="{{ route('admin.director.rejectVacation', $req->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                          <h5 class="modal-title">Rejeitar Pedido - {{ $req->employee->fullName }}</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">Motivo da Rejeição (Obrigatório)</label>
                            <textarea name="rejectionReason" class="form-control" rows="3" required placeholder="Explique o porquê da recusa..."></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-danger">Confirmar Rejeição</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center">Nenhum pedido aguardando decisão final.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</div>

@endsection
