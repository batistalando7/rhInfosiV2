@extends('layouts.admin.layout')
@section('title', 'Pedidos de Férias')
@section('content')
<div class="card mb-4 shadow" style="margin-top: 1.5rem;">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-umbrella-beach me-2"></i>Lista de Pedidos de Férias</span>
    <div>
      <a href="{{ route('admin.leaveRequestes.pdfAll') }}" class="btn btn-outline-light btn-sm" target="_blank">
        <i class="fas fa-file-earmark-pdf"></i> Baixar PDF (Todos)
      </a>
      @if(request()->filled('startDate')||request()->filled('endDate')||(request()->filled('status')&&request('status')!=='Todos'))
      <a href="{{ route('admin.leaveRequestes.pdfAll') }}?{{ http_build_query(request()->only(['startDate','endDate','status'])) }}"
         class="btn btn-outline-light btn-sm" target="_blank">
        <i class="fas fa-file-earmark-pdf"></i> Baixar PDF (Filtrados)
      </a>
      @endif
      <a href="{{ route('admin.leaveRequestes.create') }}" class="btn btn-outline-light btn-sm">
        <i class="fas fa-plus-circle"></i> Novo Pedido
      </a>
    </div>
  </div>

  <div class="card-body">
    {{-- SEARCH --}}
    <form method="GET" class="d-flex mb-3" style="max-width:320px">
      <input type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control form-control-sm rounded-start"
            placeholder="Pesquisar funcionário">
      <button class="btn btn-outline-primary btn-sm rounded-end">
        <i class="fas fa-search"></i>
      </button>
    </form>


    <form method="GET" action="{{ route('admin.leaveRequestes.index') }}" class="row g-3 mb-4">
      <div class="col-md-3">
        <label for="startDate" class="form-label">Data Início</label>
        <input type="date" name="startDate" id="startDate" class="form-control"
               value="{{ request('startDate') }}">
      </div>
      <div class="col-md-3">
        <label for="endDate" class="form-label">Data Fim</label>
        <input type="date" name="endDate" id="endDate" class="form-control"
               value="{{ request('endDate') }}">
      </div>
      <div class="col-md-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
          <option value="Todos" {{ request('status')==='Todos'?'selected':'' }}>Todos</option>
          <option value="Aprovado" {{ request('status')==='Aprovado'?'selected':'' }}>Aprovado</option>
          <option value="Validado" {{ request('status')==='Validado'?'selected':'' }}>Validado</option>
          <option value="Encaminhado" {{ request('status')==='Encaminhado'?'selected':'' }}>Encaminhado</option>
          <option value="Pendente" {{ request('status')==='Pendente'?'selected':'' }}>Pendente</option>
          <option value="Recusado" {{ request('status')==='Recusado'?'selected':'' }}>Recusado</option>
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">
          <i class="fas fa-filter"></i> Filtrar
        </button>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Funcionário</th>
            <th>Tipo de Férias</th>
            <th>Data Início</th>
            <th>Data Fim</th>
            <th>Documento</th>
            <th>Razão</th>
            <th>Status</th>
            <th>Comentário</th>
            <th>Ações</th>
            <th>Criado em</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $vr)
          <tr>
            <td>{{ $vr->employee->fullName ?? '-' }}</td>
            <td>{{ $vr->vacationType }}</td>
            <td>{{ \Carbon\Carbon::parse($vr->vacationStart)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($vr->vacationEnd)->format('d/m/Y') }}</td>
            <td>
              @if($vr->supportDocument)
                <a href="{{ asset('storage/'.$vr->supportDocument) }}" target="_blank">
                  {{ $vr->originalFileName ?? 'Ver Documento' }}
                </a>
              @else
                -
              @endif
            </td>
            <td>{{ $vr->reason ?? '-' }}</td>
            <td>
              @if($vr->approvalStatus=='Aprovado')
                <span class="badge bg-success">Aprovado</span>
              @elseif($vr->approvalStatus=='Validado')
                <span class="badge bg-info">Validado</span>
              @elseif($vr->approvalStatus=='Encaminhado')
                <span class="badge bg-primary">Encaminhado</span>
              @elseif($vr->approvalStatus=='Pendente')
                <span class="badge bg-warning">Pendente</span>
              @elseif($vr->approvalStatus=='Recusado')
                <span class="badge bg-danger">Recusado</span>
              @else
                {{ $vr->approvalStatus }}
              @endif
            </td>
            <td>{{ $vr->approvalComment ?? '-' }}</td>
            <td>
              @if($vr->approvalStatus == 'Aprovado' && $vr->signedPdfPath)
              <a href="{{ route('admin.director.downloadSignedPdf', $vr->id) }}" class="btn btn-success btn-sm" title="Baixar PDF Assinado">
                <i class="fas fa-file-pdf"></i>
              </a>
              @endif
            </td>
            <td>{{ $vr->created_at->format('d/m/Y H:i') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-center">Nenhum pedido de férias listado.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
