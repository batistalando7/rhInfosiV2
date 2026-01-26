@extends('layouts.admin.layout')
@section('title', 'Editar Tipo de Licença')
@section('content')

    <div class="card my-4 shadow">
        <div class="card-header bg-secondary text-white">
            <span><i class="fas fa-pencil-square me-2"></i>Editar Tipo de Licença</span>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6">

            <form method="POST" action="{{ route('admin.leaveTypes.update', $data->id) }}">
                @csrf
                @method('put')
                <div class="mb-3">
                    <div class="form-floating">
                        <input type="text" name="name" placeholder="" class="form-control" value="{{ old('name', $data->name) }}"
                            required>
                        <label for="name">Nome</label>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-floating">
                        <textarea name="description" placeholder="" style="height: 100px;" class="form-control">{{ old('description', $data->description) }}</textarea>
                        <label for="description">Descrição</label>
                    </div>
                </div>
                <div class="d-grid gap-2 col-4 mx-auto mt-4">
                    <button type="submit" class="btn btn-success">Atualizar Tipo de Licença</button>
        </div>
            </form>
        </div>
    </div>

@endsection
