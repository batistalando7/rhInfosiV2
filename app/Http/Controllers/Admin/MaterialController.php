<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialType;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage-inventory']);
    }

    public function index()
    {
        // Não há mais filtro por categoria
        $materials = Material::with('type')->get();

        return view('admin.materials.list.index', compact('materials'));
    }

    public function create()
    {
        // Traz todos os tipos, pois não há mais categoria
        $types = MaterialType::orderBy('name')->get();

        return view('admin.materials.create.index', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'materialTypeId'     => 'required|exists:material_types,id',
            'Name'               => 'required|string',
            'SerialNumber'       => 'required|string|unique:materials,SerialNumber',
            'Model'              => 'required|string',
            'ManufactureDate'    => 'required|date',
            'SupplierName'       => 'required|string',
            'SupplierIdentifier' => 'required|string',
            'EntryDate'          => 'required|date',
            'CurrentStock'       => 'required|integer|min:0',
            'Notes'              => 'nullable|string',
        ]);

        Material::create($data);

        return redirect()
            ->route('admin.materials.index')
            ->with('msg', 'Material cadastrado com sucesso.');
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);

        return view('admin.materials.show.index', compact('material'));
    }

    public function showPdf(Material $material)
    {
        $material->load('type', 'transactions.employee');
        // Usar PDF::loadView para garantir que os estilos do layout são aplicados
        return PDF::loadView('pdf.materials.showPdf', compact('material'))->stream('material_' . $material->id . '.pdf');
    }
 


    public function edit($id)
    {
        $material = Material::findOrFail($id);
        // Traz todos os tipos
        $types = MaterialType::orderBy('name')->get();

        return view('admin.materials.edit.index', compact('material', 'types'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $data = $request->validate([
            'materialTypeId'   => 'required|exists:material_types,id',
            'Name'             => 'required|string',
            'SerialNumber'     => 'required|string|unique:materials,SerialNumber,' . $material->id,
            'Model'            => 'required|string',
            'ManufactureDate'  => 'required|date',
            'SupplierName'     => 'required|string',
            'SupplierIdentifier' => 'required|string',
            'EntryDate'        => 'required|date',
            'Notes'            => 'nullable|string',
        ]);

        $material->update($data);

        return redirect()->back()->with('msg', 'Material atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->back()->with('msg', 'Material removido com sucesso.');
    }
}
