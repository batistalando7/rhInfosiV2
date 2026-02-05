<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infrastructure;
use App\Models\InfrastructureMoviments;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InfrastructureController extends Controller
{
    public function index()
    {

        $response['infrastructures'] = Infrastructure::orderByDesc('created_at')->get();

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
            'macAddress' => ['nullable', 'string'],
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
            return redirect()->back()->with('success', 'Adicionado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro aou adicionar!');
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
            'macAddress' => ['nullable', 'string'],
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
            return redirect()->back()->with('success', 'Atualizado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro aou atualizar!');
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
        $response['infrastructure'] = Infrastructure::where('status', false)->get();

        return view('admin.infrastructure.materialInput.index', $response);
    }

    public function materialOutput()
    {

        $response['infrastructure'] = Infrastructure::where('status', true)->get();

        return view('admin.infrastructure.materialOutput.index', $response);
    }

    public function output(Request $request)
    {
        $request->validate([
            'infrastructureId' => ['required', 'integer'],
            'document' => ['nullable', 'file'],
            'destiny' => ['nullable', 'string',  'max:255'],
            'responsible' => ['nullable', 'string',  'max:255'],
            'notes' => ['nullable', 'string',  'max:255'],
            'quantity' => ['required', 'integer', 'max:255','min:1']
        ], [
            'infrastructureId' => 'Selecione o material',
            'quantity.required' => 'Determine a quantidade',
            'quantity.min' => 'Determine quantidade igual ou superior a 1'
        ]);

        
        $data = [
            'infrastructureId' => $request->infrastructureId,
            'document' => $request->document,
            'destiny' => $request->destiny,
            'responsible' => $request->responsible,
            'notes' => $request->notes,
            'quantity' => $request->quantity,
            'type' => 'output'
        ];

        $id = $data['infrastructureId']; //pegando o id do material selecionado 
        $query = Infrastructure::findOrFail($id); //pegando a coleção dos materiais de infrastrutura
        $stockQuantity = $query->quantity; //pegando a quantidade em estoque desse mesmo material pelo id
        
        //verificando se a quantidade em estoque pode atender o pedido de registro de saida
        if(($stockQuantity - $data['quantity']) > 0){

            $stockUpdate = $stockQuantity - $data['quantity'];

            $query->quantity = $stockUpdate;
            $query->save();

            InfrastructureMoviments::create($data);


            return redirect()->route('admin.infrastructures.index')->with('success','Saída de material registrado!');
        
        }else{
            return redirect()->back()->with('error','Impossível regitrar o pedido. Quantidade exede o estoque!');
        }

    }

    public function input(Request $request)
    {
        $request->validate([
            'infrastructureId' => ['required', 'integer'],
            'document' => ['nullable', 'file'],
            'destiny' => ['nullable', 'string',  'max:255'],
            'responsible' => ['nullable', 'string',  'max:255'],
            'notes' => ['nullable', 'string',  'max:255'],
            'quantity' => ['required', 'integer', 'max:255','min:1']
        ], [
            'infrastructureId' => 'Selecione o material',
            'quantity.required' => 'Determine a quantidade',
            'quantity.min' => 'Determine quantidade igual ou superior a 1'
        ]);

        
        $data = [
            'infrastructureId' => $request->infrastructureId,
            'document' => $request->document,
            'destiny' => $request->destiny,
            'responsible' => $request->responsible,
            'notes' => $request->notes,
            'quantity' => $request->quantity,
            'type' => 'input'
        ];
        
        $id = $data['infrastructureId']; //pegando o id do material selecionado 
        $query = Infrastructure::findOrFail($id); //pegando a coleção dos materiais de infrastrutura
        $stockQuantity = $query->quantity; //pegando a quantidade em estoque desse mesmo material pelo id
        
        //verificando se a quantidade em estoque pode atender o pedido de registro de saida
        if(($stockQuantity - $data['quantity']) > 0){

            $stockUpdate = $stockQuantity + $data['quantity'];

            $query->quantity = $stockUpdate;
            $query->save();
            
            InfrastructureMoviments::create($data);


            return redirect()->route('admin.infrastructures.index')->with('success','Saída de material registrado!');
        
        }else{
            return redirect()->back()->with('error','Impossível regitrar o pedido. Quantidade exede o estoque!');
        }
        

    }
}
