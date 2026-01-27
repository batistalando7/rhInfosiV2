@extends('layouts.admin.layout')
@section('title', 'Nova Viatura')
@section('content')
<div class="card my-4 shadow">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-truck me-2"></i>Nova Viatura</span>
        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-light btn-sm">
            <i class="fa-solid fa-list"></i>
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('forms._formVehicle.index')
        </form>
    </div>
</div>
@endsection