<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Validation\Rule;

class PositionController extends Controller
{
    public function index()
    {
        $data         = Position::orderByDesc('id')->get();
        $allPositions = Position::all();
        return view('admin.position.list.index', compact('data', 'allPositions'));
    }

    public function create()
    {
        return view('admin.position.create.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:positions,name'],
        ]);

        $data = new Position();
        $data->name        = $request->name;
        $data->description = $request->description;
        $data->save();

        return redirect()->back()->with('msg', 'Cargo criado!');
    }

    public function show($id)
    {
        $data = Position::findOrFail($id);
        return view('admin.position.details.index', ['data' => $data]);
    }

    public function edit($id)
    {
        $data = Position::findOrFail($id);
        return view('admin.position.edit.index', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('positions', 'name')->ignore($id),
            ],
        ]);

        $data = Position::findOrFail($id);
        $data->name        = $request->name;
        $data->description = $request->description;
        $data->save();

        return redirect()->back()->with('msg', 'Cargo atualizado!');
    }

    public function pdf($positionId)
    {
        $position = Position::with(['employees.department', 'employees.specialty'])
                        ->findOrFail($positionId);
        $pdf      = PDF::loadView('pdf.position.employeeePdf', compact('position'));
        return $pdf->stream('RelatorioCargo.pdf');
    }

    public function pdfAll()
    {
        $allPositions = Position::all();
        $pdf          = PDF::loadView('position.positionAllPdf', compact('allPositions'));
        return $pdf->stream('RelatorioTodosCargos.pdf');
    }

    public function employeee(Request $request)
    {
        $positionId = $request->input('position');
        $position   = Position::with(['employees.department', 'employees.specialty'])
                         ->findOrFail($positionId);
        return view('admin.position.employeee', compact('position'));
    }

    public function destroy($id)
    {
        Position::where('id', $id)->delete();
        return redirect()->back()->with('msg', 'Cargo excluído!');
    }
}
