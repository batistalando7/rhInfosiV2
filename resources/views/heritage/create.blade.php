@extends('layouts.admin.layout')
@section('title', 'Novo Patrimônio')

@section('content')
<div class="card mb-4">
  <div class="card-header bg-secondary text-white">
    <i class="fas fa-plus me-2"></i> Novo Patrimônio
  </div>
  <div class="card-body">
    <form action="{{ route('heritage.store') }}" method="POST">
      @csrf
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Descrição do Patrimônio</label>
            <input type="text" name="Description" class="form-control" required value="{{ old('Description') }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Tipo de Patrimônio</label>
            <input type="text" name="Type" class="form-control" required value="{{ old('Type') }}" placeholder="ex: mobiliário, equipamento, veículo">
          </div>
          <div class="mb-3">
            <label class="form-label">Valor do Patrimônio</label>
            <input type="number" name="Value" step="0.01" class="form-control" required value="{{ old('Value') }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Data de Aquisição</label>
            <input type="date" name="AcquisitionDate" class="form-control" required value="{{ old('AcquisitionDate') }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Localização do Patrimônio</label>
            <input type="text" name="Location" class="form-control" required value="{{ old('Location') }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Responsável</label>
            <select name="ResponsibleId" class="form-select" required>
              <option value="">-- selecione --</option>
              @foreach(\App\Models\User::all() as $user)
                <option value="{{ $user->id }}" {{ old('ResponsibleId') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Estado do Patrimônio</label>
            <select name="Condition" class="form-select" required>
              <option value="novo" {{ old('Condition') == 'novo' ? 'selected' : '' }}>Novo</option>
              <option value="usado" {{ old('Condition') == 'usado' ? 'selected' : '' }}>Usado</option>
              <option value="danificado" {{ old('Condition') == 'danificado' ? 'selected' : '' }}>Danificado</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Observações</label>
            <textarea name="Observations" class="form-control" rows="3">{{ old('Observations') }}</textarea>
          </div>
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