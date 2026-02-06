@extends('layouts.admin.layout')
@section('title', 'Entrada de Material')

@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white ">
            <i class="fas fa-plus-circle me-2"></i> Registrar Entrada de Material
        </div>
        <div class="card-body">
            <form action="{{ route('admin.infrastructures.input') }}" method="POST">
                @csrf
                @method('PUT')
                
                @include('forms._formMaterialInput.index')
            </form>
        </div>
    </div>
@endsection
