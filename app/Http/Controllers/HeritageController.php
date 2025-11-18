<?php

namespace App\Http\Controllers;

use App\Models\Heritage;
use App\Models\HeritageMaintenance;
use App\Models\HeritageTransfer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeritageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage-heritage']);
    }

    public function index(Request $request)
    {
        $query = Heritage::with(['maintenances', 'transfers', 'responsible']);
        if ($request->filled('search')) {
            $query->where('Description', 'like', '%' . $request->search . '%')
                  ->orWhere('Location', 'like', '%' . $request->search . '%');
        }
        $heritages = $query->get();

        return view('heritage.index', compact('heritages'));
    }

    public function create()
    {
        return view('heritage.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Description'       => 'required|string|max:255',
            'Type'              => 'required|string|max:100',
            'Value'             => 'required|numeric|min:0',
            'AcquisitionDate'   => 'required|date',
            'Location'          => 'required|string|max:255',
            'ResponsibleId'     => 'required|exists:users,id',
            'Condition'         => 'required|in:novo,usado,danificado',
            'Observations'      => 'nullable|string',
        ]);

        $data['ResponsibleId'] = Auth::id();
        Heritage::create($data);

        return redirect()->route('heritage.index')->with('msg', 'Patrimônio cadastrado com sucesso.');
    }

    public function show($id)
    {
        $heritage = Heritage::with(['maintenances', 'transfers', 'responsible'])->findOrFail($id);

        return view('heritage.show', compact('heritage'));
    }

    public function edit($id)
    {
        $heritage = Heritage::findOrFail($id);

        return view('heritage.edit', compact('heritage'));
    }

    public function update(Request $request, $id)
    {
        $heritage = Heritage::findOrFail($id);

        $data = $request->validate([
            'Description'       => 'required|string|max:255',
            'Type'              => 'required|string|max:100',
            'Value'             => 'required|numeric|min:0',
            'AcquisitionDate'   => 'required|date',
            'Location'          => 'required|string|max:255',
            'ResponsibleId'     => 'required|exists:users,id',
            'Condition'         => 'required|in:novo,usado,danificado',
            'Observations'      => 'nullable|string',
        ]);

        $heritage->update($data);

        return redirect()->route('heritage.index')->with('msg', 'Patrimônio atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $heritage = Heritage::findOrFail($id);
        $heritage->delete();

        return redirect()->route('heritage.index')->with('msg', 'Patrimônio removido com sucesso.');
    }

    public function storeMaintenance(Request $request, $heritageId)
    {
        $data = $request->validate([
            'MaintenanceDate' => 'required|date',
            'MaintenanceDescription' => 'required|string',
            'MaintenanceResponsible' => 'required|string',
        ]);

        Heritage::findOrFail($heritageId);
        HeritageMaintenance::create($data + ['HeritageId' => $heritageId]);

        return redirect()->route('heritage.show', $heritageId)->with('msg', 'Manutenção registrada.');
    }

    public function storeTransfer(Request $request, $heritageId)
    {
        $data = $request->validate([
            'TransferDate' => 'required|date',
            'TransferReason' => 'required|string',
            'TransferResponsible' => 'required|string',
        ]);

        Heritage::findOrFail($heritageId);
        HeritageTransfer::create($data + ['HeritageId' => $heritageId]);

        return redirect()->route('heritage.show', $heritageId)->with('msg', 'Transferência registrada.');
    }

    public function report()
    {
        $heritages = Heritage::with(['maintenances', 'transfers'])->get();

        return Pdf::loadView('heritage.report', compact('heritages'))
            ->setPaper('a4', 'portrait')
            ->stream("Relatorio-Patrimonio.pdf");
    }
}