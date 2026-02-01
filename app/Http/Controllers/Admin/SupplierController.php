<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SupplierController extends Controller
{

    public function index()
    {
        $response['suppliers'] = Supplier::all();
        return view('admin.supplier.list.index', $response);
    }

    public function create()
    {
        return view('admin.supplier.create.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nif' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'site' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
        ], [
            'name' => 'É obrigatório nome!',
            'nif' => 'É obrigatório NIF',
            'address' => 'É obrigatório Endereço',
            'email' => 'Ibntroduzir um email válido',
        ]);

        /* $data = $request->except('_token'); */

        $data = Supplier::create($request->except('_token'));

        if ($data) {
            return redirect()->back()->with('Fornecedor Registrado com sucesso!');
        } else {
            return redirect()->back()->with('Erro ao registrar!');
        }
    }

    public function show($id)
    {
        $response['supplier'] = Supplier::findOrFail($id);
        return view('admin.supplier.details.index', $response);
    }

    public function edit($id)
    {
        $response['supplier'] = Supplier::findOrFail($id);

        return view('admin.supplier.edit.index', $response);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nif' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'site' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
        ], [
            'name' => 'É obrigatório nome!',
            'nif' => 'É obrigatório NIF',
            'address' => 'É obrigatório Endereço',
            'email' => 'Ibntroduzir um email válido',
        ]);

        /* $data = $request->except('_token'); */

        $data = Supplier::findOrFail($id)->update($request->except('_token'));

        if ($data) {
            return redirect()->back()->with('Fornecedor atualizado com sucesso!');
        } else {
            return redirect()->back()->with('Erro ao atualizar!');
        }
    }

    public function destroy($id)
    {
        $data = Supplier::findOrFail('$id')->delete();

        if ($data) {
            return redirect()->back()->with('Fornecedor deletado com sucesso!');
        } else {
            return redirect()->back()->with('Erro ao deletar!');
        }
    }
}
