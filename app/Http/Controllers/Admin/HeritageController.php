<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Heritage;
use App\Models\HeritageType;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class HeritageController extends Controller
{
    public function index()
    {
        $response['heritages'] = Heritage::with('heritageType')->get();
        return view('admin.heritages.list.index', $response);
    }

    public function create()
    {
        $response['heritageTypes'] = HeritageType::all();
        $response['suppliers'] = Supplier::all();
        return view('admin.heritages.create.index', $response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'max:255'],
            'heritageTypeId' => 'required',
            'supplierId' => 'required',
            'model' => ['nullable', 'string', 'max:255'],
            'manufactureDate' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'document' => ['nullable', 'file']
        ], [
            'name' => 'É obrigatório nome',
            'quantity' => 'Determine a quantidade',
            'heritageTypeId' => 'Selecione um tipo',
            'supplierId' => 'Selecione o fornecedor',
        ]);

        $data = Heritage::create($request->except('_token'));

        if ($data) {
            return redirect()->back()->with('success', 'Cadastrado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao cadastrar!');
        }
    }


    public function show($id)
    {
        $response['heritage'] = Heritage::findOrFail($id);

        return view('admin.heritages.details.index', $response);
    }

    public function edit($id)
    {
        $response['heritage'] = Heritage::findOrFail($id);
        $response['heritageTypes'] = HeritageType::all();
        $response['suppliers'] = Supplier::all();

        return view('admin.heritages.edit.index', $response);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'manufactureDate' => ['nullable', 'date'],
            'heritageTypeId' => 'required',
            'supplierId' => 'required',
            'notes' => ['nullable', 'string'],
            'document' => ['nullable', 'file']
        ], [
            'name' => 'É obrigatório nome',
            'quantity' => 'Determine a quantidade',
            'heritageTypeId' => 'Selecione um tipo',
            'supplierId' => 'Selecione o fornecedor',
        ]);

        $data = Heritage::findOrFail($id)->update($request->except('_token'));

        if ($data) {
            return redirect()->route('admin.heritages.index')->with('success', 'Património atualizado com sucesso!');
        } else {
            return redirect()->route('admin.heritages.index')->with('error', 'Erro ao atualizar!');
        }
    }

    public function destroy($id)
    {

        $data = Heritage::findOrFail($id)->delete();

        if ($data) {

            return redirect() - back()->with('success', 'Património deletado com sucesso!');
        } else {

            return redirect()->back()->with('error', 'Erro ao deletar!');
        }
    }

    /*     // Manutenção - CRUD Completo
    public function maintenance(Heritage $heritage)
    {
        return view('admin.heritages.maintenance.create', compact('heritage'));
    }

    public function storeMaintenance(Request $request, Heritage $heritage)
    {
        $request->validate([
            'MaintenanceDate' => 'required|date',
            'Description' => 'required|string',
            'ResponsibleName' => 'required|string|max:255', // Corrigido
            'MaintenanceCost' => 'nullable|numeric|min:0',
        ]);

        $heritage->maintenances()->create($request->all());

        return redirect()->route('admin.heritages.show', $heritage)->with('msg', 'Manutenção registada com sucesso!');
    }
 */
    /*  public function editMaintenance(Heritage $heritage, HeritageMaintenance $maintenance)
    {
        return view('admin.heritages.maintenance.edit', compact('heritage', 'maintenance'));
    }
    
    public function updateMaintenance(Request $request, Heritage $heritage, HeritageMaintenance $maintenance)
    {
        $request->validate([
            'MaintenanceDate' => 'required|date',
            'Description' => 'required|string',
            'ResponsibleName' => 'required|string|max:255', // Corrigido
            'MaintenanceCost' => 'nullable|numeric|min:0',
        ]);

        $maintenance->update($request->all());

        return redirect()->route('admin.heritages.show', $heritage)->with('msg', 'Manutenção atualizada com sucesso!');
    }
    
    public function destroyMaintenance(Heritage $heritage, HeritageMaintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('admin.heritages.show', $heritage)->with('msg', 'Manutenção removida com sucesso!');
    } */

    // Transferência - CRUD Completo
    /* public function transfer(Heritage $heritage)
    {
        return view('admin.heritages.transfer.create', compact('heritage'));
    }

    public function storeTransfer(Request $request, Heritage $heritage)
    {
        $request->validate([
            'TransferDate' => 'required|date',
            'Reason' => 'required|string',
            'ResponsibleName' => 'required|string|max:255', // Quem Autorizou/Executou
            'OriginLocation' => 'required|string|max:255',
            'DestinationLocation' => 'required|string|max:255',
            'TransferredToName' => 'required|string|max:255', // Quem Recebeu
        ]);

        $heritage->transfers()->create($request->all());
        
        // Atualizar a localização e o responsável no modelo Heritage
        $heritage->update([
            'Location' => $request->DestinationLocation,
            'ResponsibleName' => $request->TransferredToName,
        ]);

        return redirect()->route('admin.heritages.show', $heritage)->with('msg', 'Transferência registada com sucesso!');
    } */

    /* public function editTransfer(Heritage $heritage, HeritageTransfer $transfer)
    {
        return view('admin.heritages.transfer.edit', compact('heritage', 'transfer'));
    }
    
    public function updateTransfer(Request $request, Heritage $heritage, HeritageTransfer $transfer)
    {
        $request->validate([
            'TransferDate' => 'required|date',
            'Reason' => 'required|string',
            'ResponsibleName' => 'required|string|max:255',
            'OriginLocation' => 'required|string|max:255',
            'DestinationLocation' => 'required|string|max:255',
            'TransferredToName' => 'required|string|max:255',
        ]);

        $transfer->update($request->all());
        
        // Atualizar a localização e o responsável no modelo Heritage
        $heritage->update([
            'Location' => $request->DestinationLocation,
            'ResponsibleName' => $request->TransferredToName,
        ]);

        return redirect()->route('admin.heritages.show', $heritage)->with('msg', 'Transferência atualizada com sucesso!');
    }
    
    public function destroyTransfer(Heritage $heritage, HeritageTransfer $transfer)
    {
        $transfer->delete();
        return redirect()->route('admin.heritages.show', $heritage)->with('msg', 'Transferência removida com sucesso!');
    }

    // Relatórios
    public function reportAll()
    {
        $heritages = Heritage::with('type')->get();
        // Usar PDF::loadView para garantir que os estilos do layout são aplicados
        return PDF::loadView('admin.heritages.report-all', compact('heritages'))->stream('patrimonio_total.pdf');
    }
    
    public function showPdf(Heritage $heritage)
    {
        $history = $heritage->fullHistory();
        // Usar PDF::loadView para garantir que os estilos do layout são aplicados
        return PDF::loadView('admin.heritages.show-pdf', compact('heritage', 'history'))->stream('patrimonio_' . $heritage->id . '.pdf');
    } */
}
