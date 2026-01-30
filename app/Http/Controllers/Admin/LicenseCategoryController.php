<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenseCategory;
use Illuminate\Http\Request;

class LicenseCategoryController extends Controller
{
    /**
     * Lista todas as categorias de carta.
     */
    public function index()
    {
        $categories = LicenseCategory::orderBy('name')->get();
        return view('admin.licenseCategories.list.index', compact('categories'));
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return view('admin.licenseCategories.create.index');
    }

    /**
     * Armazena nova categoria.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:50|unique:license_categories,name',
            'description' => 'nullable|string',
        ]);

        LicenseCategory::create($data);

        return redirect()
            ->route('admin.licenseCategories.index')
            ->with('msg', 'Categoria criada com sucesso.');
    }

    /**
     * Formulário de edição.
     */
    public function edit(LicenseCategory $licenseCategory)
    {
        return view('admin.licenseCategories.edit.index', compact('licenseCategory'));
    }

    /**
     * Atualiza uma categoria existente.
     */
    public function update(Request $request, LicenseCategory $licenseCategory)
    {
        $data = $request->validate([
            'name'        => "required|string|max:50|unique:license_categories,name,{$licenseCategory->id}",
            'description' => 'nullable|string',
        ]);

        $licenseCategory->update($data);

        return redirect()
            ->route('admin.licenseCategories.index')
            ->with('msg', 'Categoria atualizada com sucesso.');
    }

    /**
     * Remove uma categoria.
     */
    public function destroy(LicenseCategory $licenseCategory)
    {
        $licenseCategory->delete();

        return redirect()->back()->with('msg', 'Categoria removida.');
    }
}
