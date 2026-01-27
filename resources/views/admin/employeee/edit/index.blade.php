@extends("layouts.admin.layout") 
@section("title", "Editar Funcionário")
@section("content") 

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-pencil-square me-2"></i>Editar Funcionário</span>
    <a href="{{ route('admin.employeee.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="fa-solid fa-list"></i>
    </a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.employeee.update', $employee->id) }}" enctype="multipart/form-data">
      @csrf
      @method("PUT")

      @include("forms._formEmployeee.index", ['employee' => $employee])

      {{-- <div class="d-grid gap-2 col-6 mx-auto mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="fas fa-save2 me-2"></i>Atualizar Funcionário
        </button>
      </div> --}}
    </form>
  </div>
</div>

@endsection