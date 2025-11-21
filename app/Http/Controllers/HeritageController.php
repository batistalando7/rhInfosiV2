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

    public function index()
    {
        $heritages = Heritage::with('responsible')->latest()->paginate(15);
        return view('heritage.index', compact('heritages'));
    }

    public function create()
    {
        return view('heritage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Description'     => 'required|string|max:255',
            'Type'            => 'required|string|max:100',
            'Value'           => 'required|numeric|min:0',
            'AcquisitionDate' => 'required|date',
            'Location'        => 'required|string|max:255',
            'Condition'       => 'required|in:novo,usado,danificado',
            'Observations'    => 'nullable|string',
        ]);

        Heritage::create([
            'Description'           => $request->Description,
            'Type'                  => $request->Type,
            'Value'                 => $request->Value,
            'AcquisitionDate'       => $request->AcquisitionDate,
            'Location'              => $request->Location,
            'ResponsibleId'         => Auth::id(),
            'Condition'             => $request->Condition,
            'Observations'          => $request->Observations,
            'FormResponsibleName'   => Auth::user()->name ?? Auth::user()->fullName ?? Auth::user()->email,
            'FormResponsibleEmail'  => Auth::user()->email,
            'FormResponsiblePhone'  => Auth::user()->phone ?? null,
            'FormDate'              => now(),
        ]);

        return redirect()->route('heritage.index')->with('success', 'Patrimônio cadastrado com sucesso!');
    }

    public function show(Heritage $heritage)
    {
        $heritage->load(['maintenances', 'transfers', 'responsible']);
        return view('heritage.show', compact('heritage'));
    }

    public function edit(Heritage $heritage)
    {
        return view('heritage.edit', compact('heritage'));
    }

    public function update(Request $request, Heritage $heritage)
    {
        $request->validate([
            'Description'     => 'required|string|max:255',
            'Type'            => 'required|string|max:100',
            'Value'           => 'required|numeric|min:0',
            'AcquisitionDate' => 'required|date',
            'Location'        => 'required|string|max:255',
            'Condition'       => 'required|in:novo,usado,danificado',
            'Observations'    => 'nullable|string',
        ]);

        $heritage->update($request->only([
            'Description', 'Type', 'Value', 'AcquisitionDate', 'Location', 'Condition', 'Observations'
        ]));

        return redirect()->route('heritage.show', $heritage)->with('success', 'Patrimônio atualizado!');
    }

    public function destroy(Heritage $heritage)
    {
        $heritage->delete();
        return redirect()->route('heritage.index')->with('success', 'Patrimônio removido.');
    }

    // === MANUTENÇÃO ===
    public function createMaintenance(Heritage $heritage)
    {
        return view('heritage.maintenances.create', compact('heritage'));
    }

    public function storeMaintenance(Request $request, Heritage $heritage)
    {
        $request->validate([
            'MaintenanceDate' => 'required|date',
            'MaintenanceDescription' => 'required|string',
            'MaintenanceResponsible' => 'required|string',
        ]);

        $heritage->maintenances()->create($request->all());

        return redirect()->route('heritage.show', $heritage)->with('success', 'Manutenção registrada!');
    }

    // === TRANSFERÊNCIA ===
    public function createTransfer(Heritage $heritage)
    {
        return view('heritage.transfers.create', compact('heritage'));
    }

    public function storeTransfer(Request $request, Heritage $heritage)
    {
        $request->validate([
            'TransferDate' => 'required|date',
            'TransferReason' => 'required|string',
            'TransferResponsible' => 'required|string',
        ]);

        $heritage->transfers()->create($request->all());

        return redirect()->route('heritage.show', $heritage)->with('success', 'Transferência registrada!');
    }

    public function pdfAll()
        {
            $heritages = Heritage::with(['responsible', 'maintenances', 'transfers'])->latest()->get();

            $pdf = PDF::loadView('heritage.pdf_all', compact('heritages'))
                ->setPaper('a4', 'portrait');

            return $pdf->stream('Relatorio_Completo_Patrimonio_' . now()->format('d-m-Y') . '.pdf');
        }

        public function pdfSingle($id)
        {
            $heritage = Heritage::with(['responsible', 'maintenances', 'transfers'])
                ->findOrFail($id);

            $pdf = PDF::loadView('heritage.pdf_single', compact('heritage'))
                ->setPaper('a4', 'portrait');

            return $pdf->stream("Patrimonio_{$heritage->id}_{$heritage->Description}.pdf");
        }
}