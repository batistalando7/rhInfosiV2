<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeritageType;
use Illuminate\Http\Request;

class HeritageTypeController extends Controller
{
    public function index()
    {
        $types = HeritageType::all();
        return view('admin.heritageTypes.list.index', compact('types'));
    }

    public function create()
    {
        return view('admin.heritageTypes.create.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:heritage_types,name',
            'description' => 'nullable|string',
        ]);

        HeritageType::create($request->all());

        return redirect()->route('admin.heritageTypes.index')->with('msg', 'Tipo de Património criado com sucesso!');
    }

    public function show($id)
    {
        $heritageType = HeritageType::findOrFail($id);
        return view('admin.heritageTypes.details.index', ['type' => $heritageType]);
    }

    public function edit(HeritageType $heritageType)
    {
        return view('admin.heritageTypes.edit.index', ['type' => $heritageType]);
    }

    public function update(Request $request, HeritageType $heritageType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:heritage_types,name,' . $heritageType->id,
            'description' => 'nullable|string',
        ]);

        $heritageType->update($request->all());

        return redirect()->route('admin.heritageTypes.index')->with('msg', 'Tipo de Património atualizado com sucesso!');
    }

    public function destroy(HeritageType $heritageType)
    {
        if ($heritageType->heritages()->count() > 0) {
            return redirect()->back()->with('error', 'Não é possível remover. Existem patrimónios associados a este tipo.');
        }

        $heritageType->delete();

        return redirect()->back()->with('msg', 'Tipo de Património removido com sucesso!');
    }
}
