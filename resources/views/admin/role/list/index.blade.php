@extends("layouts.admin.layout")
@section("title", "Cursos")
@section("content")

<div class="card mt-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-book me-2"></i>Todos os Cursos</span>
    <div>
      <a href="{{ route("admin.roles.create") }}" class="btn btn-outline-light btn-sm" title="Adicionar Novo Curso"> 
        Novo <i class="fas fa-plus-circle"></i>
      </a>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="datatablesSimple" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome do Curso</th>
            <th>Descrição</th>
            <th style="width: 58px;">Ação</th>
          </tr>
        </thead>
        <tbody>
            @forelse($roles as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->description ?? "-" }}</td>
                <td>
                  <a href="{{ route("admin.roles.show", $item->id) }}" class="btn btn-warning btn-sm" title="Visualizar">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route("admin.roles.edit", $item->id) }}" class="btn btn-info btn-sm" title="Editar">
                    <i class="fas fa-pencil"></i>
                  </a>
                  <a href="#" data-url="{{ route('admin.roles.destroy', $item->id) }}" class="btn btn-danger btn-sm delete-btn" title="Apagar">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            @empty
            <p>Nenhum registro</p>
            @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection


