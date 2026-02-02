@extends('layouts.admin.layout')
@section('title', 'Novo Material')

@section('content')
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-plus-circle me-2"></i> Adicionar Novo Material
        </div>
        <div class="card-body">
            <form action="{{ route('admin.infrastructures.store') }}" method="POST">
                @csrf
                
                @include('forms._formMaterialCreate.index')
            </form>
        </div>
    </div>
@endsection
