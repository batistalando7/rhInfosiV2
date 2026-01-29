<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employeee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

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
    private function countWeekdays(Carbon $start, Carbon $end)
    {
        $days = 0;
        $current = $start->copy();
        while ($current->lte($end)) {
            if ($current->isWeekday()) {
                $days++;
            }
            $current->addDay();
        }
        return $days;
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

        $startDate = Carbon::parse($employee->entry_date)->startOfDay();
        $endDate   = Carbon::now()->endOfYear();
        $totalWeekDays = $this->countWeekdays($startDate, $endDate);

        $records = AttendanceRecord::where('employeeId', $id)
            ->whereBetween('recordDate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();
        $employee['presences'] = $records->count();
        $employee['justifiedDays'] = $records->whereIn('status', ['Férias', 'Licença', 'Doença', 'Teletrabalho'])->count();
        $employee['injustifiedDays'] = $totalWeekDays - ($employee->presences + $employee->justifiedDays);
        $employee['records'] = $records;
        $employee['totalWeekDays'] = $totalWeekDays;
        $pdf = PDF::loadView('pdf.employeee.history', compact('employee'))->setPaper('a4', 'portrait');
        /* return $pdf->stream('historico_funcionario_' . $employee->id . '.pdf'); */
        return view('pdf.employeee.history', compact('employee'));
        /* return response()->json($employee->department); */
    }
}
