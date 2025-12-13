<?php

namespace App\Http\Controllers;

use App\Models\Heritage;
use App\Models\HeritageType;
use App\Models\HeritageMaintenance;
use App\Models\HeritageTransfer;
use Illuminate\Http\Request;
use PDF; // Assumindo que está a usar um pacote de PDF

class HeritageController extends Controller
{
    public function index()
    {
        $heritages = Heritage::with('type')->get();
        return view('heritages.index', compact('heritages'));
    }

    public function create()
    {
        $types = HeritageType::all();
        return view('heritages.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'heritageTypeId' => 'required|exists:heritage_types,id',
            'Description' => 'required|string',
            'Value' => 'required|numeric|min:0',
            'AcquisitionDate' => 'required|date',
            'Location' => 'required|string|max:255',
            'ResponsibleName' => 'required|string|max:255',
            'Condition' => 'required|in:Novo,Usado,Danificado,Em Manutenção,Avariado',
            'Notes' => 'nullable|string',
            'DocumentationPath' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Novo: Validação do ficheiro
        ]);

        $path = null;
        if ($request->hasFile('DocumentationPath')) {
            // Salvar o ficheiro na pasta 'heritage_docs' dentro de storage/app/public
            $path = $request->file('DocumentationPath')->store('heritage_docs', 'public');
        }

        Heritage::create(array_merge($request->all(), ['DocumentationPath' => $path]));

        return redirect()->route('heritages.index')->with('msg', 'Património cadastrado com sucesso!');
    }


    public function show(Heritage $heritage)
    {
        $history = $heritage->fullHistory();
        return view('heritages.show', compact('heritage', 'history'));
    }

    public function edit(Heritage $heritage)
    {
        $types = HeritageType::all();
        return view('heritages.edit', compact('heritage', 'types'));
    }

    public function update(Request $request, Heritage $heritage)
    {
        $request->validate([
            'heritageTypeId' => 'required|exists:heritage_types,id',
            'Description' => 'required|string',
            'Value' => 'required|numeric|min:0',
            'AcquisitionDate' => 'required|date',
            'Location' => 'required|string|max:255',
            'ResponsibleName' => 'required|string|max:255', // Corrigido
            'Condition' => 'required|in:Novo,Usado,Danificado,Em Manutenção,Avariado',
            'Notes' => 'nullable|string',
        ]);

        $heritage->update($request->all());

        return redirect()->route('heritages.index')->with('msg', 'Património atualizado com sucesso!');
    }

    public function destroy(Heritage $heritage)
    {
        $heritage->delete();
        return redirect()->route('heritages.index')->with('msg', 'Património removido com sucesso!');
    }
    
    // Manutenção - CRUD Completo
    public function maintenance(Heritage $heritage)
    {
        return view('heritages.maintenance.create', compact('heritage'));
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

        return redirect()->route('heritages.show', $heritage)->with('msg', 'Manutenção registada com sucesso!');
    }
    
    public function editMaintenance(Heritage $heritage, HeritageMaintenance $maintenance)
    {
        return view('heritages.maintenance.edit', compact('heritage', 'maintenance'));
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

        return redirect()->route('heritages.show', $heritage)->with('msg', 'Manutenção atualizada com sucesso!');
    }
    
    public function destroyMaintenance(Heritage $heritage, HeritageMaintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('heritages.show', $heritage)->with('msg', 'Manutenção removida com sucesso!');
    }

    // Transferência - CRUD Completo
    public function transfer(Heritage $heritage)
    {
        return view('heritages.transfer.create', compact('heritage'));
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

        return redirect()->route('heritages.show', $heritage)->with('msg', 'Transferência registada com sucesso!');
    }
    
    public function editTransfer(Heritage $heritage, HeritageTransfer $transfer)
    {
        return view('heritages.transfer.edit', compact('heritage', 'transfer'));
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

        return redirect()->route('heritages.show', $heritage)->with('msg', 'Transferência atualizada com sucesso!');
    }
    
    public function destroyTransfer(Heritage $heritage, HeritageTransfer $transfer)
    {
        $transfer->delete();
        return redirect()->route('heritages.show', $heritage)->with('msg', 'Transferência removida com sucesso!');
    }

    // Relatórios
    public function reportAll()
    {
        $heritages = Heritage::with('type')->get();
        // Usar PDF::loadView para garantir que os estilos do layout são aplicados
        return PDF::loadView('heritages.report-all', compact('heritages'))->stream('patrimonio_total.pdf');
    }
    
    public function showPdf(Heritage $heritage)
    {
        $history = $heritage->fullHistory();
        // Usar PDF::loadView para garantir que os estilos do layout são aplicados
        return PDF::loadView('heritages.show-pdf', compact('heritage', 'history'))->stream('patrimonio_' . $heritage->id . '.pdf');
    }
}
