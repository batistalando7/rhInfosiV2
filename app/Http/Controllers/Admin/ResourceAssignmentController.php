<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employeee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Models\ResourceAssignment;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ResourceAssignmentController extends Controller
{

    public function index()
    {
        $response['resourceAssignments'] = ResourceAssignment::with(['vehicle', 'employeee'])->orderByDesc('id')->get();
        return view('admin.resourceAssignment.list.index', $response);
    }

    public function create(Request $request)
    {
        if (!$request->has('employeeSearch')) {
            return view('admin.resourceAssignment.create.index');
        }
        $request->validate([
            'employeeSearch' => 'required|string',
        ]);
        $term = $request->employeeSearch;

        $vehicles = Vehicle::orderByDesc('id')->get();
        $employee = Employeee::where('employmentStatus', 'active')
            ->where(function ($q) use ($term) {
                $q->where('id', $term)
                    ->orWhere('fullName', 'LIKE', "%{$term}%");
            })
            ->first();
        if (!$employee) {
            return redirect()->back()
                ->withErrors(['employeeSearch' => 'Funcionário não encontrado!'])
                ->withInput();
        }
        return view('admin.resourceAssignment.create.index', [
            'employee'          => $employee,
            'vehicles'         => $vehicles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employeeeId' => 'required|exists:employeees,id',
            'vehicleId'   => 'required|exists:vehicles,id',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'notes'       => 'nullable|string',
        ]);

        $data = ResourceAssignment::create([
            'employeeeId' => $request->employeeeId,
            'vehicleId'   => $request->vehicleId,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'notes'       => $request->notes,
        ]);

        if ($data) {
            return redirect()->route('admin.resourceAssignments.index')->with('msg', 'Recurso atribuído com sucesso.');
        } else {
            return redirect()->back()->with('err', 'Erro ao atribuir recurso. Tente novamente mais tarde.');
        }
    }

    public function show(ResourceAssignment $resourceAssignment)
    {
        return view('admin.resourceAssignment.details.index', compact('resourceAssignment'));
    }

    public function edit(ResourceAssignment $resourceAssignment)
    {
        $vehicles = Vehicle::orderByDesc('id')->get();
        return view('admin.resourceAssignment.edit.index', compact('resourceAssignment', 'vehicles'));
    }

    public function update(Request $request, ResourceAssignment $resourceAssignment)
    {
        $request->validate([
            'vehicleId'   => 'required|exists:vehicles,id',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'notes'       => 'nullable|string',
        ]);

        $resourceAssignment->update([
            'vehicleId'   => $request->vehicleId,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'notes'       => $request->notes,
        ]);
        return redirect()->route('admin.resourceAssignments.index')->with('msg', 'Atribuição de recurso atualizada com sucesso.');
    }

    public function destroy(ResourceAssignment $resourceAssignment)
    {
        $resourceAssignment->delete();
        return redirect()->route('admin.resourceAssignment.index')->with('msg', 'Recurso atribuído excluído com sucesso.');
    }

    public function pdfAll()
    {
        $allResourceAssignments = ResourceAssignment::with(['vehicle', 'employeee'])->get();
        $pdf = PDF::loadView('pdf.resourceAssignment.resourceAssignments_pdf', compact('allResourceAssignments'))
            ->setPaper('a3', 'landscape');
        return $pdf->download('Relatorio-Recursos-Atribuidos.pdf');
    }

    /**
     * Busca um funcionário por ID ou Nome.
     */
    /* public function searchEmployee(Request $request)
    {
        $request->validate([
            'employeeSearch' => 'required|string',
        ]);
        $term = $request->employeeSearch;
        
        $response['vehicles'] = Vehicle::orderByDesc('id')->get();
        $employee = Employeee::where('employmentStatus', 'active')
            ->where(function($q) use ($term) {
                $q->where('id', $term)
                  ->orWhere('fullName', 'LIKE', "%{$term}%");
            })
            ->first();
        if (!$employee) {
            return redirect()->back()
                ->withErrors(['employeeSearch' => 'Funcionário não encontrado!'])
                ->withInput();
        }
        $currentDepartment = $employee->department;
        $departments = Department::all();
        $leaveTypes = LeaveType::all();
        return view('admin.resourceAssignment.create.index', [
            'departments'       => $departments,
            'leaveTypes'        => $leaveTypes,
            'employee'          => $employee,
            'currentDepartment' => $currentDepartment,
        ]);
    } */
}
