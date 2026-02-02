@extends('layouts.admin.layout')
@section('title', 'Saida de Material')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-plus-circle me-2"></i> Registrar Saída de Material
        </div>
        <div class="card-body">
            <form action="{{ route('materials.store') }}" method="POST">
                @csrf
                
                @include('forms._formMaterialOutput.index')
            </form>
        </div>
    </div>
@endsection
