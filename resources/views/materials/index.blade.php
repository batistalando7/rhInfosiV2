@extends('layouts.admin.layout')
@section('title','Estoque — Infraestrutura')

@section('content')
<div class="card mb-4">
  <div class="card-header bg-secondary text-white d-flex justify-content-between">
    <span><i class="fas fa-boxes me-2"></i>Estoque — Infraestrutura</span>
    <div>
      <a href="{{ route('materials.create') }}" class="btn btn-sm btn-primary">
        <i class="fas fa-plus-circle"></i> Novo Material
      </a>
      <a href="{{ route('materials.transactions.in') }}" class="btn btn-sm btn-success">
        <i class="fas fa-arrow-down-circle"></i> Entrada
      </a>
      <a href="{{ route('materials.transactions.out') }}" class="btn btn-sm btn-warning">
        <i class="fas fa-arrow-up-circle"></i> Saída
      </a>
      <a href="{{ route('materials.transactions.index') }}" class="btn btn-sm btn-info">
        <i class="fas fa-clock-history"></i> Histórico
      </a>
    </div>
  </div>
  <div class="card-body">
    @if(session('msg'))
      <div class="alert alert-success">{{ session('msg') }}</div>
    @endif
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Tipo</th>
          <th>Modelo</th>
          <th>Fabricado</th>
          <th>Estoque</th>
          <th style="width: 58px;">Ação</th>
        </tr>
      </thead>
      <tbody>
        @forelse($materials as $m)
          <tr>
            <td>{{ $m->Name }}</td>
            <td>{{ $m->type->name }}</td>
            <td>{{ $m->Model }}</td>
            <td>{{ \Carbon\Carbon::parse($m->ManufactureDate)->format('d/m/Y') }}</td>
            <td>{{ $m->CurrentStock }}</td>
            <td class="text-center">
              <a href="{{ route('materials.show', $m->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
              <a href="{{ route('materials.edit', $m->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil"></i></a>
              <a href="#" data-url="{{ route('materials.destroy', $m->id) }}" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"></i></a>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center">Nenhum material cadastrado.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<script>
// JS básico para delete-btn (se não tiveres, adiciona SweetAlert ou confirma)
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Tem certeza?')) {
            window.location = this.dataset.url;
        }
    });
});
</script>
@endsection