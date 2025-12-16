@extends('layouts.admin.layout')
@section('title', 'Novo Tipo de Material')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-plus-circle me-2"></i> Cadastrar Novo Tipo de Material
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form action="{{ route('material-types.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="name" id="name" class="form-control" placeholder=""
                                    value="{{ old('name') }}" required>
                                <label for="name">Nome do Tipo</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea name="description" id="description" class="form-control" placeholder=""
                                    style="height: 100px;">{{ old('description') }}</textarea>
                                <label for="description">Descrição (opcional)</label>
                            </div>
                        </div>

                             <div class="d-grid gap-2 col-4 mx-auto mt-4">
                            <button class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Salvar
                            </button>
                            <a href="{{ route('material-types.index') }}" class="btn btn-secondary ms-2">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
