<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF; // Assumindo que está a usar um pacote de PDF

class MaterialTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = MaterialTransaction::with('material', 'employee');

        if ($request->filled('startDate')) {
            $query->whereDate('TransactionDate', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('TransactionDate', '<=', $request->endDate);
        }
        if ($request->filled('type')) {
            $type = $request->type == 'in' ? 'Entrada' : 'Saída';
            $query->where('TransactionType', $type);
        }

        $txs = $query->orderBy('TransactionDate', 'desc')->get();

        return view('material_transactions.index', compact('txs'));
    }

    public function createIn()
    {
        $materials = Material::with('type')->get();
        return view('material_transactions.create', ['type' => 'in', 'materials' => $materials]);
    }

    public function storeIn(Request $request)
    {
        $request->validate([
            'MaterialId' => 'required|exists:materials,id',
            'Quantity' => 'required|integer|min:1',
            'TransactionDate' => 'required|date',
            'OriginOrDestination' => 'required|string|max:255',
            'DocumentationPath' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'Notes' => 'nullable|string',
        ]);

        $material = Material::find($request->MaterialId);
        $material->CurrentStock += $request->Quantity;
        $material->save();

        $path = null;
        if ($request->hasFile('DocumentationPath')) {
            $path = $request->file('DocumentationPath')->store('material_docs', 'public');
        }

        MaterialTransaction::create([
    'MaterialId' => $request->MaterialId,
    'TransactionType' => 'Entrada', // 
    'Quantity' => $request->Quantity,
    'TransactionDate' => $request->TransactionDate,
    'OriginOrDestination' => $request->OriginOrDestination,
    'DocumentationPath' => $path,
    'Notes' => $request->Notes,
    'CreatedBy' => null,
]);


        return redirect()->route('materials.transactions.index')->with('msg', 'Entrada de material registada com sucesso!');
    }

    public function createOut()
    {
        $materials = Material::with('type')->get();
        return view('material_transactions.create', ['type' => 'out', 'materials' => $materials]);
    }

    public function storeOut(Request $request)
    {
        $request->validate([
            'MaterialId' => 'required|exists:materials,id',
            'Quantity' => 'required|integer|min:1',
            'TransactionDate' => 'required|date',
            'OriginOrDestination' => 'required|string|max:255',
            'DocumentationPath' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'Notes' => 'nullable|string',
        ]);

        $material = Material::find($request->MaterialId);

        if ($material->CurrentStock < $request->Quantity) {
            return back()->withInput()->with('error', 'Estoque insuficiente para esta saída.');
        }

        $material->CurrentStock -= $request->Quantity;
        $material->save();

        $path = null;
        if ($request->hasFile('DocumentationPath')) {
            $path = $request->file('DocumentationPath')->store('material_docs', 'public');
        }

        MaterialTransaction::create([
    'MaterialId' => $request->MaterialId,
    'TransactionType' => 'Saída', //
    'Quantity' => $request->Quantity,
    'TransactionDate' => $request->TransactionDate,
    'OriginOrDestination' => $request->OriginOrDestination,
    'DocumentationPath' => $path,
    'Notes' => $request->Notes,
    'CreatedBy' => null, //null é teste quando não tem funcionarios registrados. quando tem é para usar: 'CreatedBy' => auth()->id(),
]);


        return redirect()->route('materials.transactions.index')->with('msg', 'Saída de material registada com sucesso!');
    }

    public function reportIn()
    {
        $transactions = MaterialTransaction::where('TransactionType', 'Entrada')
            ->with('material', 'employee')
            ->orderBy('TransactionDate', 'desc')
            ->get();
            
        // Usar PDF::loadView para garantir que os estilos do layout são aplicados
        return PDF::loadView('material_transactions.report-in', compact('transactions'))->stream('relatorio_entrada_material.pdf');
    }

    public function reportOut()
    {
        $transactions = MaterialTransaction::where('TransactionType', 'Saída')
            ->with('material', 'employee')
            ->orderBy('TransactionDate', 'desc')
            ->get();
            
        // Usar PDF::loadView para garantir que os estilos do layout são aplicados
        return PDF::loadView('material_transactions.report-out', compact('transactions'))->stream('relatorio_saida_material.pdf');
    }

    public function reportAll()
    {
        $transactions = MaterialTransaction::with('material', 'employee')
            ->orderBy('TransactionDate', 'desc')
            ->get();
            
        // Usar PDF::loadView para garantir que os estilos do layout são aplicados
        return PDF::loadView('material_transactions.report-all', compact('transactions'))->stream('relatorio_total_material.pdf');
    }

}
