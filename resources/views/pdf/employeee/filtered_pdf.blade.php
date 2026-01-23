@extends('layouts.admin.pdf')

@section('Title', 'Relatório de Funcionários Filtrados')

@section('titleSection')
    <h4>Relatório de Funcionários </h4>
    <p style="text-align: center;">
        @if ($startDate && $endDate)
            <strong>Filtrados no Período de:</strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} a
            {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
        @endif
        <strong>Total de Funcionários:</strong> <ins>{{ $filtered->count() }}</ins>
    </p>
@endsection

@section('contentTable')
    @if ($filtered->count())
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Completo</th>
                    @if ($selectedDepartment != null)
                        <th>Departamento</th>
                    @endif
                    @if ($selectedPosition != null)
                        <th>Cargo</th>
                    @endif
                    @if ($selectedSpeciality != null)
                        <th>Especialidade</th>
                    @endif
                    @if ($selectedType != null)
                        <th>Tipo de Funcionário</th>
                    @endif
                    {{-- <th>Categoria</th>
                    <th>Nível Acadêmico</th>
                    <th>Curso</th> --}}
                    <th>Data de Ingresso</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filtered as $emp)
                    <tr>
                        <td>{{ $emp->id }}</td>
                        <td>{{ $emp->fullName }}</td>
                        @if ($selectedDepartment != null)
                            <td>{{ $emp->department->title ?? '-' }}</td>
                        @endif
                        @if ($selectedPosition != null)
                            <td>{{ $emp->position->name ?? '-' }}</td>
                        @endif
                        @if ($selectedSpeciality != null)
                            <td>{{ $emp->specialty->name ?? '-' }}</td>
                        @endif
                        @if ($selectedType != null)
                            <td>{{ $emp->employeeType->name ?? '-' }}</td>
                        @endif
                        {{-- <td>{{ $emp->employeeCategory->name ?? '-' }}</td>
                        <td>{{ $emp->academicLevel ?? '-' }}</td>
                        <td>{{ $emp->course->name ?? '-' }}</td> --}}
                        <td>{{ $emp->entry_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center;">Nenhum funcionário encontrado no filtro aplicado.</p>
    @endif
@endsection
