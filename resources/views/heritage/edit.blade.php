@extends('layouts.admin.layout')
@section('title', 'Editar Patrimônio')

@section('content')
<div class="card mb-4">
  <div class="card-header bg-secondary text-white">
    <i class="fas fa-edit me-2"></i> Formulário de Controlo de Patrimônio
  </div>
  <div class="card-body">
    <form action="{{ route('heritage.update', $heritage->id) }}" method="POST">
      @csrf @method('PUT')
      <h5>Informações do Patrimônio</h5>
      <div class="row">
        <div class="col-md-12 mb-3">
          <label class="form-label">Descrição do Patrimônio</label>
          <input type="text" name="Description" class="form-control" required value="{{ old('Description', $heritage->Description) }}">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Tipo de Patrimônio (ex: mobiliário, equipamento, veículo, etc.)</label>
          <input type="text" name="Type" class="form-control" required value="{{ old('Type', $heritage->Type) }}">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Valor do Patrimônio</label>
          <input type="number" name="Value" step="0.01" class="form-control" required value="{{ old('Value', $heritage->Value) }}">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Data de Aquisição</label>
          <input type="date" name="AcquisitionDate" class="form-control" required value="{{ old('AcquisitionDate', $heritage->AcquisitionDate->format('Y-m-d')) }}">
        </div>
      </div>

      <h5>Localização do Patrimônio</h5>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Localização</label>
          <input type="text" name="Location" class="form-control" required value="{{ old('Location', $heritage->Location) }}">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Responsável</label>
          <select name="ResponsibleId" class="form-select" required>
            <option value="">-- selecione --</option>
            @foreach(\App\Models\User::all() as $u)
              <option value="{{ $u->id }}" {{ old('ResponsibleId', $heritage->ResponsibleId) == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <h5>Estado do Patrimônio</h5>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Condição (ex: novo, usado, danificado, etc.)</label>
          <select name="Condition" class="form-select" required>
            <option value="novo" {{ old('Condition', $heritage->Condition) == 'novo' ? 'selected' : '' }}>Novo</option>
            <option value="usado" {{ old('Condition', $heritage->Condition) == 'usado' ? 'selected' : '' }}>Usado</option>
            <option value="danificado" {{ old('Condition', $heritage->Condition) == 'danificado' ? 'selected' : '' }}>Danificado</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Observações</label>
          <textarea name="Observations" class="form-control" rows="3">{{ old('Observations', $heritage->Observations) }}</textarea>
        </div>
      </div>

      <h5>Responsável pelo Formulário</h5>
      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Nome</label>
          <input type="text" name="FormResponsibleName" class="form-control" required value="{{ old('FormResponsibleName', $heritage->FormResponsibleName) }}">
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">Telefone</label>
          <input type="text" name="FormResponsiblePhone" class="form-control" value="{{ old('FormResponsiblePhone', $heritage->FormResponsiblePhone) }}">
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="FormResponsibleEmail" class="form-control" required value="{{ old('FormResponsibleEmail', $heritage->FormResponsibleEmail) }}">
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-md-12">
          <label class="form-label">Data do Formulário</label>
          <input type="date" name="FormDate" class="form-control" required value="{{ old('FormDate', $heritage->FormDate ? $heritage->FormDate->format('Y-m-d') : now()->format('Y-m-d')) }}">
        </div>
      </div>

      <div class="text-center">
        <button class="btn btn-success">Atualizar</button>
        <a href="{{ route('heritage.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
      </div>
    </form>
  </div>
</div>
@endsection