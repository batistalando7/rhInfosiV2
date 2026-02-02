<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infrastructure;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InfrastructureController extends Controller
{
    public function index()
    {

        $response['infrastructures'] = Infrastructure::where('status', true)->orderByDesc('created_at')->get();

        return view('admin.infrastructure.list.index', $response);
    }

    public function create()
    {

        $response['supplier'] = Supplier::all();

        return view('admin.infrastructure.create.index', $response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'serialNumber' => ['nullable', 'string'],
            'model' => ['nullable', 'string', 'max:255'],
            'supplierId' => ['required', 'integer', 'max:255'],
            'manufactureDate' => ['nullable', 'date', 'max:255'],
            'entryDate' => ['required', 'date', 'max:255'],
            'quantity' => ['required', 'integer', 'max:255'],
            'document' => ['nullable', 'file', 'mimes:pdf,txt,docx'],
            'notes' => ['nullable', 'string', 'max:255'],
        ], [
            'name' => 'É obrigatório o nome',
            'supplierId' => 'É obrigatório o id do fornecedor',
            'entryDate' => 'É obrigatório a data de entrada no estoque',
            'quantity' => 'É obrigatório a quantidade',
        ]);

        $data = Infrastructure::create($request->except('_token'));

        if ($data) {
            return redirect()->back()->with('Adicionado com sucesso!');
        } else {
            return redirect()->back()->with('Erro aou adicionar!');
        }
    }

    public function show($id)
    {

        $response['infrastructure'] = Infrastructure::findOrFail($id);

        return view('admin.infrastructure.details.index', $response);
    }

    public function edit($id)
    {

        $response['infrastructure'] = Infrastructure::findOrFail($id);
        $response['supplier'] = Supplier::all();

        return view('admin.infrastructure.edit.index', $response);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'serialNumber' => ['nullable', 'string'],
            'model' => ['nullable', 'string', 'max:255'],
            'supplierId' => ['required', 'integer', 'max:255'],
            'manufactureDate' => ['nullable', 'date', 'max:255'],
            'entryDate' => ['required', 'date', 'max:255'],
            'quantity' => ['required', 'integer', 'max:255'],
            'document' => ['nullable', 'file', 'mimes:pdf,txt,docx'],
            'notes' => ['nullable', 'string', 'max:255'],
        ], [
            'name' => 'É obrigatório o nome',
            'supplierId' => 'É obrigatório o id do fornecedor',
            'entryDate' => 'É obrigatório a data de entrada no estoque',
            'quantity' => 'É obrigatório a quantidade',
        ]);

        $data = Infrastructure::findOrFail($id)->update($request->except('_token'));

        if ($data) {
            return redirect()->back()->with('Atualizado com sucesso!');
        } else {
            return redirect()->back()->with('Erro aou atualizar!');
        }
    }

    public function destroy($id)
    {
        $data = Infrastructure::delete($id);

        if ($data) {
            return redirect()->back()->with('Deletado com sucesso!');
        } else {
            return redirect()->back()->with('Erro aou Deletar!');
        }
    }

    public function materialInput()
    {

        return view('admin.infrastructure.materialInput.index');
    }

    public function materialOutput(Request $request)
    {

        $response['infrastructure'] = Infrastructure::all();
        
        $data = [
            'id' => $request->infrastructureId,
            'document' => $request->document,
            'notes' => $request->notes
        ];


        if (!isset($data)) {
             return view('admin.infrastructure.materialOutput.index', $response);
        }

        /* return response()->json('fudeu'); */
        return view('admin.infrastructure.materialOutput.index', $response);
    }

    public function output(Request $request){
        $request->validate([
            'infrastructureId' => 'required'
        ]);
        $id = $request->infrastructureId;
        $data = Infrastructure::findOrFail($id);
        $data->status = false;
        $data->save();
        return redirect()->route('admin.infrastructures.index')->with('Saída de material registrado!');
    }
}
