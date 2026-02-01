@extends('layouts.admin.layout')
@section('title', 'Fornecedores')

@section('content')
<div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-tools me-2"></i> Editar Fornecedor</span>
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-light btn-sm">
                <i class="fa-solid fa-list"></i>
            </a>
        </div>
        <div class="card-body">
            @if (session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
            <form action="{{ route('admin.suppliers.update', $supplier->id)}}" method="post">
                @csrf
                @method('PUT')

                {{-- formulario --}}
                @include('forms._formSupplier.index')
            </form>
        </div>
    </div>
@endsection