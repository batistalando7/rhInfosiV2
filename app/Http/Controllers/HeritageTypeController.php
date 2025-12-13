<?php

namespace App\Http\Controllers;

use App\Models\HeritageType;
use Illuminate\Http\Request;

class HeritageTypeController extends Controller
{
    public function index()
    {
        $types = HeritageType::all();
        return view('heritage_types.index', compact('types'));
    }

    public function create()
    {
        return view('heritage_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:heritage_types,name',
            'description' => 'nullable|string',
        ]);

        HeritageType::create($request->all());

        return redirect()->route('heritage-types.index')->with('msg', 'Tipo de Património criado com sucesso!');
    }

    public function show(HeritageType $heritageType)
    {
        return view('heritage_types.show', ['type' => $heritageType]);
    }

    public function edit(HeritageType $heritageType)
    {
        return view('heritage_types.edit', ['type' => $heritageType]);
    }

    public function update(Request $request, HeritageType $heritageType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:heritage_types,name,' . $heritageType->id,
            'description' => 'nullable|string',
        ]);

        $heritageType->update($request->all());

        return redirect()->route('heritage-types.index')->with('msg', 'Tipo de Património atualizado com sucesso!');
    }

    public function destroy(HeritageType $heritageType)
    {
        if ($heritageType->heritages()->count() > 0) {
            return redirect()->route('heritage-types.index')->with('error', 'Não é possível remover. Existem patrimónios associados a este tipo.');
        }

        $heritageType->delete();

        return redirect()->route('heritage-types.index')->with('msg', 'Tipo de Património removido com sucesso!');
    }
}
