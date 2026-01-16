<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employeee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Models\ResourceAssignment;

class ResourceAssignmentController extends Controller
{

    public function index()
    {
        $response['resourceAssignments'] = ResourceAssignment::orderByDesc('id')->get();
        return view('admin.resourceAssignment.list.index', $response);
    }

    public function create()
    {
        $response['employeees'] = Employeee::orderBy('fullName')->get();
        return view('admin.resourceAssignment.create.index', $response);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ResourceAssignment $resourceAssignment)
    {
        return view('admin.resourceAssignment.details.index', compact('resourceAssignment'));
    }

    public function edit(ResourceAssignment $resourceAssignment)
    {
        return view('admin.resourceAssignment.edit.index', compact('resourceAssignment'));
    }

    public function update(Request $request, ResourceAssignment $resourceAssignment)
    {
        //
    }

    public function destroy(ResourceAssignment $resourceAssignment)
    {
        $resourceAssignment->delete();
        return redirect()->route('admin.resourceAssignment.index')->with('msg', 'Recurso atribuído excluído com sucesso.');
    }

    
    
    /**
     * Busca um funcionário por ID ou Nome.
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
    }
}
