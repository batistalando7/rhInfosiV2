<?php

namespace App\Http\Controllers;

use App\Models\MaterialType;
use Illuminate\Http\Request;

class MaterialTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','can:manage-inventory']);
    }

    public function index()
    {
        $types = MaterialType::where('category', 'infraestrutura')->get();

        return view('material_types.index', compact('types'));
    }

    public function create()
    {
        return view('material_types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string',
            'description' => 'nullable|string',
            'category'    => 'required|in:infraestrutura',
        ]);

        MaterialType::create($data);

        return redirect()->route('material-types.index')->with('msg', 'Tipo criado.');
    }

    public function show($id)
    {
        $type = MaterialType::findOrFail($id);

        return view('material_types.show', compact('type'));
    }

    public function edit($id)
    {
        $type = MaterialType::findOrFail($id);

        return view('material_types.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = MaterialType::findOrFail($id);

        $data = $request->validate([
            'name'        => 'required|string',
            'description' => 'nullable|string',
        ]);

        $type->update($data);

        return redirect()->route('material-types.index')->with('msg', 'Tipo atualizado.');
    }

    public function destroy($id)
    {
        $type = MaterialType::findOrFail($id);
        $type->delete();

        return redirect()->route('material-types.index')->with('msg', 'Tipo removido.');
    }
}