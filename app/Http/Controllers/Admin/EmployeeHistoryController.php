<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employeee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\LeaveRequest;
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

        // start Trabalhando dados da efetividade
        $startDate = Carbon::parse($employee->entry_date)->startOfDay(); //pegando a data de ingresso a isntituição
        $endDate   = Carbon::now()->endOfYear(); //pegando a data presente
        $totalWeekDays = $this->countWeekdays($startDate, $endDate); //calculando apenas todas os dias úteis
        //pegando a coleção da tabela efetividades    
        $records = AttendanceRecord::where('employeeId', $id)
            ->whereBetween('recordDate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();
        $employee['presences'] = $records->count(); //contando as presenças maracadas no sistema
        //pegando dias justificados como (ferias, licenca, etc)
        $employee['justifiedDays'] = $records->whereIn('status', ['Férias', 'Licença', 'Doença', 'Teletrabalho'])->count();
        //pegando todos os dias não justificados também
        $employee['injustifiedDays'] = $totalWeekDays - ($employee->presences + $employee->justifiedDays);
        //passando os dados na variável objeto employee
        $employee['records'] = $records;
        $employee['totalWeekDays'] = $totalWeekDays;

        /* end Trabalhando dados da efetividade */

        /* pegando as licencas */
        $employee['leaveRequest'] = LeaveRequest::with('employee')->where('approvalStatus', 'Aprovado')->where('employeeId', $id)->get();
        /* $employee['leaveDays'] = $employee->leaveRequest->leaveEnd - $employee->leaveRequest->leaveStart; */
        
        $pdf = PDF::loadView('pdf.employeee.history', compact('employee'))->setPaper('a4', 'portrait');
        /* return $pdf->stream('historico_funcionario_' . $employee->id . '.pdf'); */
        return view('pdf.employeee.history', compact('employee'));
        /* return response()->json($employee->department); */
    }
}
