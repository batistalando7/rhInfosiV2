<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employeee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class EmployeeHistoryController extends Controller
{
    public function index($id)
    {
        $employee = Employeee::with([
            'department',
            'employeeType',
            'positionHistories',
            'mobilities.oldDepartment',
            'mobilities.newDepartment',
            'secondments',
            'extraJobs',
            'salaryPayments',
        ])->findOrFail($id);

        return view('admin.employeee.history', compact('employee'));
    }

    public function employeeHistoryPdf($id)
    {
        $employee = Employeee::with([
            'department',
            'employeeType',
            'positionHistories',
            'mobilities.oldDepartment',
            'mobilities.newDepartment',
            'secondments',
            'extraJobs',
            'salaryPayments',
        ])->findOrFail($id);

        $pdf = PDF::loadView('pdf.employeee.history', compact('employee'))->setPaper('a4', 'portrait');
        return $pdf->stream('historico_funcionario_' . $employee->id . '.pdf');
        /* return view('pdf.employeee.history', compact('employee')); */

    }
}