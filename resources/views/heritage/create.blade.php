@extends('layouts.admin.layout')
@section('title', 'Novo Patrimônio')

@section('content')
<div class="card mb-4">
  <div class="card-header bg-secondary text-white">
    <i class="fas fa-plus me-2"></i> Formulário de Controlo de Patrimônio
  </div>
  <div class="card-body">
    <form action="{{ route('heritage.store') }}" method="POST">
      @csrf
      <h5>Informações do Patrimônio</h5>
      <div class="row">
        <div class="col-md-12 mb-3">
          <label class="form-label">Descrição do Patrimônio</label>
          <input type="text" name="Description" class="form-control" required value="{{ old('Description') }}">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Tipo de Patrimônio (ex: mobiliário, equipamento, veículo, etc.)</label>
          <input type="text" name="Type" class="form-control" required value="{{ old('Type') }}">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Valor do Patrimônio</label>
          <input type="number" name="Value" step="0.01" class="form-control" required value="{{ old('Value') }}">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Data de Aquisição</label>
          <input type="date" name="AcquisitionDate" class="form-control" required value="{{ old('AcquisitionDate') }}">
        </div>
      </div>

      <h5>Localização do Patrimônio</h5>
      <div class="row">
        <div class="col-md-12 mb-3">
          <label class="form-label">Localização</label>
          <input type="text" name="Location" class="form-control" required value="{{ old('Location') }}">
        </div>
        <div class="col-md-12 mb-3">
          <label class="form-label">Responsável</label>
          <input type="text" name="responsible_name" class="form-control" readonly value="{{ $user->name ?? $user->fullName ?? 'Usuário Logado' }}" style="background-color: #f8f9fa;">
          <input type="hidden" name="ResponsibleId" value="{{ Auth::id() }}"> <!-- Hidden para salvar ID auto -->
        </div>
      </div>

      <h5>Estado do Patrimônio</h5>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Condição (ex: novo, usado, danificado, etc.)</label>
          <select name="Condition" class="form-select" required>
            <option value="novo" {{ old('Condition') == 'novo' ? 'selected' : '' }}>Novo</option>
            <option value="usado" {{ old('Condition') == 'usado' ? 'selected' : '' }}>Usado</option>
            <option value="danificado" {{ old('Condition') == 'danificado' ? 'selected' : '' }}>Danificado</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Observações</label>
          <textarea name="Observations" class="form-control" rows="3">{{ old('Observations') }}</textarea>
        </div>
      </div>

      <h5>Responsável pelo Formulário</h5>
      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Nome</label>
          <input type="text" name="FormResponsibleName" class="form-control" required value="{{ old('FormResponsibleName', $user->name ?? $user->fullName ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">Telefone</label>
          <input type="text" name="FormResponsiblePhone" class="form-control" value="{{ old('FormResponsiblePhone', $user->phone ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="FormResponsibleEmail" class="form-control" required value="{{ old('FormResponsibleEmail', $user->email ?? '') }}">
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-md-12">
          <label class="form-label">Data do Formulário</label>
          <input type="date" name="FormDate" class="form-control" required value="{{ old('FormDate', now()->format('Y-m-d')) }}">
        </div>
      </div>

      <div class="text-center">
        <button class="btn btn-success">Salvar</button>
        <a href="{{ route('heritage.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
      </div>
    </form>
  </div>
</div>
@endsection