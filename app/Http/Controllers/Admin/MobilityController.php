<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mobility;
use App\Models\Employeee;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMobilityNotification;

class MobilityController extends Controller
{
    public function index(Request $request)
{
    $query = Mobility::with(['employee','oldDepartment','newDepartment']);

    if ($request->filled('search')) {
        $query->whereHas('employee', fn($q) =>
            $q->where('fullName','LIKE','%'.$request->search.'%')
        );
    }

    $data = $query->orderBy('created_at','desc')->get();

    return view('admin.mobility.list.index', compact('data'));
}


    public function create()
    {
        $departments = Department::all();
        return view('admin.mobility.create.index', compact('departments'));
    }

    /**
     * Busca um funcionário por ID ou Nome (somente funcionários ativos).
     */
    public function searchEmployee(Request $request)
    {
        $request->validate([
            'employeeSearch' => 'required|string',
        ]);

        $term = $request->employeeSearch;
        $employee = Employeee::where('employmentStatus', 'active')
            ->where(function($q) use ($term) {
                $q->where('id', $term)
                  ->orWhere('fullName', 'LIKE', "%{$term}%");
            })->first();

        if (!$employee) {
            return redirect()->back()
                ->withErrors(['employeeSearch' => 'Funcionário não encontrado!'])
                ->withInput();
        }

        $oldDepartment = $employee->department;
        $departments = Department::all();

        return view('admin.mobility.create.index', [
            'departments'   => $departments,
            'employee'      => $employee,
            'oldDepartment' => $oldDepartment,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employeeId'      => 'required|integer|exists:employeees,id',
            'oldDepartmentId' => 'nullable|integer|exists:departments,id',
            'newDepartmentId' => 'required|integer|exists:departments,id',
            'causeOfMobility' => 'nullable|string',
        ]);

        // Cria o registro de mobilidade
        $mobility = Mobility::create([
            'employeeId'      => $request->employeeId,
            'oldDepartmentId' => $request->oldDepartmentId,
            'newDepartmentId' => $request->newDepartmentId,
            'causeOfMobility' => $request->causeOfMobility,
        ]);

        //registrar no histórico do funcionário
        /* $history = $mobility->employeeHistory()->create([
            'employeeId'   => $request->employeeId,
            'mobilityId'   => $mobility->id,
        ]); */

        // Atualiza o departamento do funcionário
        $employee = Employeee::find($request->employeeId);
        $oldDepartment = $employee->department;
        $employee->departmentId = $request->newDepartmentId;
        $employee->save();

        // Envia o e-mail notificando a mobilidade
        $newDepartment = Department::find($request->newDepartmentId);
        Mail::to($employee->email)->send(new NewMobilityNotification($employee, $oldDepartment, $newDepartment, $request->causeOfMobility));

        return redirect()->route('admin.mobilities.index')
                         ->with('msg', 'Mobilidade registrada com sucesso e e-mail enviado!');
    }

    public function pdfAll()
    {
        $allMobility = Mobility::with(['employee', 'oldDepartment', 'newDepartment'])
                                ->orderByDesc('id')
                                ->get();

        $pdf = PDF::loadView('pdf.mobility.mobilityPdf', compact('allMobility'))
                  ->setPaper('a3', 'portrait');

        return $pdf->stream('RelatorioMobilidades.pdf');
    }

    public function destroy($id)
    {
        Mobility::destroy($id);
        return redirect()->route('admin.mobilities.index');
    }
}
