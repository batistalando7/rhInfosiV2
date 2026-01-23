<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeType;

class EmployeeTypeController extends Controller
{
    // Exibe a lista de tipos de funcionários
    public function index()
    {
        $data = EmployeeType::orderByDesc('id')->get();
        return view('admin.employeeType.list.index', compact('data'));
    }

    // Exibe o formulário para criar um novo tipo de funcionário
    public function create()
    {
        return view('admin.employeeType.create.index');
    }

    // Armazena o novo tipo de funcionário no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:employee_types,name',
            'description' => 'nullable|string',
        ]);

        $employeeType = new EmployeeType();
        $employeeType->name = $request->name;
        $employeeType->description = $request->description;
        $employeeType->save();

        return redirect()->back()->with('msg', 'Tipo de Funcionário cadastrado com sucesso!');
    }

    // Exibe os detalhes de um tipo de funcionário específico
    public function show($id)
    {
        $data = EmployeeType::findOrFail($id);
        return view('admin.employeeType.details.index', compact('data'));
    }

    // Exibe o formulário para editar um tipo de funcionário
    public function edit($id)
    {
        $data = EmployeeType::findOrFail($id);
        return view('admin.employeeType.edit.index', compact('data'));
    }

    // Atualiza o registro do tipo de funcionário
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:employee_types,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $employeeType = EmployeeType::findOrFail($id);
        $employeeType->name = $request->name;
        $employeeType->description = $request->description;
        $employeeType->save();

        return redirect()->back()->with('msg', 'Tipo de Funcionário atualizado com sucesso!');
    }

    // Remove um tipo de funcionário do banco de dados
    public function destroy($id)
    {
        EmployeeType::destroy($id);
        return redirect()->back()->with('msg', 'Tipo de Funcionário removido com sucesso!');
    }
}
