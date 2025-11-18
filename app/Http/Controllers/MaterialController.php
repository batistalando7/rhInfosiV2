<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialType;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','can:manage-inventory']);
    }

    public function index(Request $request)
    {
        $query = Material::with('type'); // Sempre infra, sem filtro de categoria
        $materials = $query->get();

        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        $types = MaterialType::where('category', 'infraestrutura')
                             ->orderBy('name')->get();

        return view('materials.create', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Category'           => 'required|in:infraestrutura', // Só infra
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
            ->route('materials.index')
            ->with('msg','Material cadastrado com sucesso.');
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);

        return view('materials.show', compact('material'));
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $types = MaterialType::where('category', 'infraestrutura')
                             ->orderBy('name')->get();

        return view('materials.edit', compact('material','types'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $data = $request->validate([
            'materialTypeId'   => 'required|exists:material_types,id',
            'Name'             => 'required|string',
            'Model'            => 'required|string',
            'ManufactureDate'  => 'required|date',
            'Notes'            => 'nullable|string',
        ]);

        $material->update($data);

        return redirect()
            ->route('materials.index')
            ->with('msg','Material atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()
            ->route('materials.index')
            ->with('msg','Material removido com sucesso.');
    }
}