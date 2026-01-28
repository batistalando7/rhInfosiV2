@extends('layouts.admin.layout')
@section('title', 'Editar Viatura')
@section('content')
<div class="card my-4 shadow">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-truck me-2"></i>Editar Viatura #{{ $vehicle->id }}</span>
        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-light btn-sm">
            <i class="fa-solid fa-list"></i>
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('forms._formVehicle.index')
        </form>
    </div>
</div>
@endsection