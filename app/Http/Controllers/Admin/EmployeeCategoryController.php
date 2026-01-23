<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeCategory;
use Illuminate\Http\Request;

class EmployeeCategoryController extends Controller
{
    public function index()
    {
        $employeeCategories = EmployeeCategory::all();
        return view("admin.employeeCategory.list.index", compact("employeeCategories"));
    }

    public function create()
    {
        return view("admin.employeeCategory.create.index");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:employee_categories|max:255",
            "description" => "nullable|string", 
        ]);

        EmployeeCategory::create($request->all());

        return redirect()->back()->with("msg", "Categoria de Funcionário criada com sucesso!");
    }

    public function show($id)
    {
        $employeeCategory = EmployeeCategory::findOrFail($id);
        return view("admin.employeeCategory.details.index", compact("employeeCategory"));
    }

    public function edit( $id)
    {
        $employeeCategory = EmployeeCategory::findOrFail($id);
        return view("admin.employeeCategory.edit.index", compact("employeeCategory"));
    }

    public function update(Request $request, $id)
    {
        $employeeCategory = EmployeeCategory::findOrFail($id);
        $request->validate([
            "name" => "required|max:255|unique:employee_categories,name," . $employeeCategory->id,
            "description" => "nullable|string",
        ]);

        $employeeCategory->update($request->all());

        return redirect()->back()->with("msg", "Categoria de Funcionário atualizada com sucesso!");
    }

    public function destroy(EmployeeCategory $employeeCategory)
    {
        $employeeCategory->delete();
        return redirect()->back()->with("msg", "Categoria de Funcionário excluída com sucesso!");
    }
}


