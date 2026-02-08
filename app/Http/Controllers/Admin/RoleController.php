<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {
        $response['roles'] = Role::orderByDesc('created_at')->get();

        return view('admin.role.list.index', $response);
    }

    public function create()
    {

        return view('admin.role.create.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string']
        ], [
            'name' => 'Digite o nome da função'
        ]);

        $data = Role::create($request->except('_token'));

        if ($data) {
            return redirect()->back()->with('success', 'Cadastrado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao cadastrar!');
        }
    }

    public function show($id)
    {

        $response['role'] = Role::findOrFail($id);

        return view('admin.role.details.index', $response);
    }

    public function edit($id)
    {
        $response['role'] = Role::findOrFail($id);

        return view('admin.role.edit.index', $response);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
