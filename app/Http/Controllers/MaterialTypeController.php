<?php

namespace App\Http\Controllers;

use App\Models\MaterialType;
use Illuminate\Http\Request;

class MaterialTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage-inventory']);
    }

    public function index()
    {
        // Não há mais filtro por categoria
        $types = MaterialType::orderBy('name')->get();
        return view('material_types.index', compact('types'));
    }

    public function create()
    {
        return view('material_types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:material_types,name',
            'description' => 'nullable|string',
        ]);

        MaterialType::create($data);

        return redirect()
            ->route('material-types.index')
            ->with('msg', 'Tipo de Material cadastrado com sucesso.');
    }

    public function show(MaterialType $materialType)
    {
        return view('material_types.show', ['type' => $materialType]);
    }

    public function edit(MaterialType $materialType)
    {
        return view('material_types.edit', ['type' => $materialType]);
    }

    public function update(Request $request, MaterialType $materialType)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:material_types,name,' . $materialType->id,
            'description' => 'nullable|string',
        ]);

        $materialType->update($data);

        return redirect()
            ->route('material-types.index')
            ->with('msg', 'Tipo de Material atualizado com sucesso.');
    }

    public function destroy(MaterialType $materialType)
    {
        if ($materialType->materials()->count() > 0) {
            return redirect()
                ->route('material-types.index')
                ->with('error', 'Não é possível remover. Existem Materiais associados a este tipo.');
        }

        $materialType->delete();

        return redirect()
            ->route('material-types.index')
            ->with('msg', 'Tipo de Material removido com sucesso.');
    }
}