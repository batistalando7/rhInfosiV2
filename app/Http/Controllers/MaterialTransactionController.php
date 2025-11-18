<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage-inventory']);
    }

    public function index(Request $request)
    {
        $query = MaterialTransaction::whereHas('material', fn ($q) =>
            $q->where('Category', 'infraestrutura') // Só infra
        )->with(['material.type', 'department', 'creator']);

        if ($request->filled('startDate')) {
            $query->whereDate('TransactionDate', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('TransactionDate', '<=', $request->endDate);
        }
        if ($request->filled('type')) {
            $query->where('TransactionType', $request->type);
        }

        $txs = $query->orderByDesc('TransactionDate')->get();

        return view('material_transactions.index', compact('txs'));
    }

    protected function form()
    {
        $materials = Material::where('Category', 'infraestrutura')
                             ->with('type')
                             ->get();

        $type = request()->get('type', 'in'); // Default in

        return view('material_transactions.create', compact('materials','type'));
    }

    public function createIn()
    {
        return $this->form();
    }

    public function createOut()
    {
        return $this->form();
    }

    protected function storeTx(Request $r, $type)
    {
        $data = $r->validate([
            'MaterialId'            => 'required|exists:materials,id',
            'TransactionDate'       => 'required|date',
            'Quantity'              => 'required|integer|min:1',
            'OriginOrDestination'   => 'required|string',
            'DocumentationPath'     => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'Notes'                 => 'nullable|string',
        ]);

        $material = Material::findOrFail($data['MaterialId']);

        // Valida categoria
        if ($material->Category !== 'infraestrutura') {
            abort(403, 'Você não tem permissão para movimentar este material.');
        }

        $delta = $type === 'in' ? $data['Quantity'] : -$data['Quantity'];
        $material->increment('CurrentStock', $delta);

        if ($r->hasFile('DocumentationPath')) {
            $data['DocumentationPath'] = $r->file('DocumentationPath')
                ->store('material_docs', 'public');
        }

        // Define campos de rastreamento
        $employee = Auth::user()->employee;
        $data += [
            'TransactionType' => $type,
            'DepartmentId'    => $employee->departmentId,
            'CreatedBy'       => $employee->id,
        ];

        MaterialTransaction::create($data);

        return redirect()
            ->route('materials.transactions.index')
            ->with('msg', 'Transação registrada com sucesso.');
    }

    public function storeIn(Request $r)
    {
        return $this->storeTx($r, 'in');
    }

    public function storeOut(Request $r)
    {
        return $this->storeTx($r, 'out');
    }

    public function reportIn()
    {
        $builder = MaterialTransaction::where('TransactionType', 'in')
            ->whereHas('material', fn ($q) => $q->where('Category', 'infraestrutura'))
            ->with(['material.type', 'department', 'creator']);

        $txs = $builder->orderByDesc('TransactionDate')->get();

        return Pdf::loadView('material_transactions.report-in', compact('txs'))
            ->setPaper('a4', 'landscape')
            ->stream("Entradas-Infra.pdf");
    }

    public function reportOut()
    {
        $builder = MaterialTransaction::where('TransactionType', 'out')
            ->whereHas('material', fn ($q) => $q->where('Category', 'infraestrutura'))
            ->with(['material.type', 'department', 'creator']);

        $txs = $builder->orderByDesc('TransactionDate')->get();

        return Pdf::loadView('material_transactions.report-out', compact('txs'))
            ->setPaper('a4', 'landscape')
            ->stream("Saidas-Infra.pdf");
    }

    public function reportAll()
    {
        $builder = MaterialTransaction::whereHas('material', fn ($q) => $q->where('Category', 'infraestrutura'))
            ->with(['material.type', 'department', 'creator']);

        $txs = $builder->orderByDesc('TransactionDate')->get();

        return Pdf::loadView('material_transactions.report-all', compact('txs'))
            ->setPaper('a4', 'landscape')
            ->stream("TodasTransacoes-Infra.pdf");
    }
}