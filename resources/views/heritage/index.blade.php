@extends('layouts.admin.layout')
@section('title', 'Controlo de Patrimônio')

@section('content')
<div class="card mb-4">
  <div class="card-header bg-secondary text-white d-flex justify-content-between">
    <span><i class="fas fa-building me-2"></i>Patrimônio</span>
    <div>
      <a href="{{ route('heritage.create') }}" class="btn btn-sm btn-primary">
        <i class="fas fa-plus"></i> Novo Patrimônio
      </a>
      <a href="{{ route('heritage.report') }}" class="btn btn-sm btn-info" target="_blank">
        <i class="fas fa-file-pdf"></i> Relatório PDF
      </a>
    </div>
  </div>
  <div class="card-body">
    <form method="GET" class="mb-3">
      <div class="row">
        <div class="col-md-6">
          <input type="text" name="search" class="form-control" placeholder="Pesquisar por descrição ou localização" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
          <button class="btn btn-primary">Filtrar</button>
        </div>
      </div>
    </form>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Descrição</th>
          <th>Tipo</th>
          <th>Valor</th>
          <th>Condição</th>
          <th>Localização</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($heritages as $h)
          <tr>
            <td>{{ $h->Description }}</td>
            <td>{{ $h->Type }}</td>
            <td>{{ number_format($h->Value, 2) }} AKZ</td>
            <td><span class="badge bg-{{ $h->Condition == 'novo' ? 'success' : ($h->Condition == 'usado' ? 'warning' : 'danger') }}">{{ ucfirst($h->Condition) }}</span></td>
            <td>{{ $h->Location }}</td>
            <td>
              <a href="{{ route('heritage.show', $h->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
              <a href="{{ route('heritage.edit', $h->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
              <a href="#" data-url="{{ route('heritage.destroy', $h->id) }}" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></a>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center">Nenhum patrimônio cadastrado.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection