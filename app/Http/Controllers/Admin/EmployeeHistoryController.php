<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employeee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            /* 'salaryPayments', */
        ])->findOrFail($id);

        return view('admin.employeee.history', compact('employee'));
    }
}