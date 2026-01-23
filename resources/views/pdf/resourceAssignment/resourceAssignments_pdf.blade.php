@extends("layouts.admin.pdf")

@section("pdfTitle", "Relatório de Todos os Funcionários")

@section("titleSection")
  <h4>Relatório de Todos os recursos atribuidos</h4>
  <p style="text-align: center;">
    <strong>Total de Recursos Atribuídos:</strong> <ins>{{ $allResourceAssignments->count() }}</ins>
  </p>
@endsection

@section("contentTable")
  @if($allResourceAssignments->count())
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Veículo</th>
          <th>Funcionário Atribuido</th>
          <th>Departamento</th>
          <th>Cargo</th>
           <th>Telefone</th>
          <th>Email</th>
          {{--<th>Nível Acadêmico</th>
          <th>Curso</th>
          <th>Email</th> --}}
        </tr>
      </thead>
      <tbody>
        @foreach($allResourceAssignments as $item)
          <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->vehicle->brand. ' - ' . $item->vehicle->model. ' - ' . $item->vehicle->plate ?? "-" }}</td>
            <td>{{ $item->employeee->fullName }}</td>
            <td>{{ $item->employeee->department->title ?? "-" }}</td>
            <td>{{ $item->employeee->position->name ?? "-" }}</td>
             <td>{{ $item->employeee->mobile ?? "-" }}</td>
            <td>{{ $item->employeee->email ?? "-" }}</td>
            {{--<td>{{ $item->course->name ?? "-" }}</td>
            <td>{{ $item->email }}</td> --}}
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style="text-align: center;">Não há funcionários cadastrados.</p>
  @endif
@endsection

