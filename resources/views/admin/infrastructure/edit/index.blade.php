@extends('layouts.admin.layout')
@section('title', 'Novo Material')

@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-plus-circle me-2"></i> Editar Material
        </div>
        <div class="card-body">
            <form action="{{ route('admin.infrastructures.update', $infrastructure->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @include('forms._formMaterialCreate.index')
            </form>
        </div>
    </div>
@endsection
