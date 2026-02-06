@extends('layouts.admin.layout')
@section('title', 'Saida de Material')

@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white">
            <i class="fas fa-plus-circle me-2"></i> Registrar Saída de Material
        </div>
        <div class="card-body">
            <form action="{{ route('admin.heritages.output') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @include('forms._formHeritageOutput.index')
            </form>
        </div>
    </div>
@endsection
