@extends('layouts.admin.layout')
@section('title', 'Novo Material')

@section('content')
    <div class="card mt-4 shadow">
        <div class="card-header bg-secondary text-white">
            <a href="{{ route('admin.heritages.index')}}" class="btn btn-outline-secondary btn-sm" title="Ver todos"><i class="fas fa-list me-3"></i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.heritages.store') }}" method="POST">
                @csrf
                
                @include('forms._formHeritageCreate.index')
            </form>
        </div>
    </div>
@endsection
