<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialty;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;

class SpecialtyController extends Controller
{
    public function index()
    {
        $data           = Specialty::orderByDesc('id')->get();
        $allSpecialties = Specialty::orderByDesc('name')->get();
        return view('admin.specialty.list.index', compact('data', 'allSpecialties'));
    }

    public function create()
    {
        return view('admin.specialty.create.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:specialties,name'],
        ]);

        $data = new Specialty();
        $data->name        = $request->name;
        $data->description = $request->description;
        $data->save();

        return redirect()->back()->with('msg', 'Especialidade criada!');
    }

    public function show($id)
    {
        $data = Specialty::findOrFail($id);
        return view('admin.specialty.details.index', ['data' => $data]);
    }

    public function edit($id)
    {
        $data = Specialty::findOrFail($id);
        return view('admin.specialty.edit.index', ['data' => $data]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('specialties', 'name')->ignore($id),
            ],
        ]);

        $data = Specialty::findOrFail($id);
        $data->name        = $request->name;
        $data->description = $request->description;
        $data->save();

        // Aqui fizemos a correção: usei o route helper para apontar para /specialties/{id}/edit
        return redirect()->back()->with('msg', 'Especialidade atualizada!');
    }

    public function employeee(Request $request)
    {
        $specialtyId = $request->input('specialty');
        $specialty   = Specialty::with(['employees.department', 'employees.position'])
                          ->findOrFail($specialtyId);
        return view('admin.specialty.employeee', compact('specialty'));
    }

    public function pdf($specialtyId)
    {
        $specialty = Specialty::with(['employees.department', 'employees.position'])
                         ->findOrFail($specialtyId);
        $pdf       = PDF::loadView('pdf.specialty.employeeePdf', compact('specialty'));
        return $pdf->stream('RelatorioEspecialidade.pdf');
    }

    public function destroy($id)
    {
        Specialty::where('id', $id)->delete();
        return redirect()->back()->with('msg', 'Especialidade apagada!');
    }
}