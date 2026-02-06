@extends('layouts.admin.layout')
@section('title', 'Editar Tipo de Património')

@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-edit me-2"></i> Editar Tipo de Património
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form action="{{ route('heritage-types.update', $type->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="name" id="name" class="form-control" placeholder=""
                                    value="{{ old('name', $type->name) }}" required>
                                <label for="name">Nome do Tipo</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea name="description" id="description" class="form-control" placeholder=""
                                    style="height: 100px;">{{ old('description', $type->description) }}</textarea>
                                <label for="description">Descrição (opcional)</label>
                            </div>
                        </div>

                           <div class="d-grid gap-2 col-4 mx-auto mt-4">
                            <button class="btn btn-primary">
                                <i class="fas fa-check me-1"></i> Atualizar
                            </button>
                            <a href="{{ route('heritage-types.index') }}" class="btn btn-secondary ms-2">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
