<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\SalaryPayment;
use App\Models\Employeee;
use App\Models\AttendanceRecord;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Mail\SalaryPaidNotification;

class SalaryPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->role === 'employee'
            ? SalaryPayment::where('employeeId', auth()->user()->employee->id)
                ->with(['employee.department','employee.employeeType'])
            : SalaryPayment::with(['employee.department','employee.employeeType']);

        if ($request->filled('startDate')) {
            $query->whereDate('paymentDate', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('paymentDate', '<=', $request->endDate);
        }

        $salaryPayments = $query->orderByDesc('created_at')->get();
        $salaryPayments->each(function($p){
            $p->paymentStatus = $this->translateStatus($p->paymentStatus);
        });

        return view('salaryPayment.index', [
            'salaryPayments' => $salaryPayments,
            'filters'        => $request->only('startDate','endDate'),
        ]);
    }

    public function create()
    {
        return view('salaryPayment.create'); // agora a view cuida da pesquisa
    }

    // Nova rota AJAX para autocomplete
    public function searchEmployeeAjax(Request $request)
    {
        $query = $request->get('q', '');
        $employees = Employeee::with('department')
            ->where('fullName', 'LIKE', "%{$query}%")
            ->where('employmentStatus', 'active')
            ->orderBy('fullName')
            ->limit(10)
            ->get();

        $results = $employees->map(function($e) {
            $dept = $e->department ? $e->department->title : 'Sem departamento';
            return [
                'id'   => $e->id,
                'text' => $e->fullName,
                'extra'=> "Depto: {$dept}"
            ];
        });

        return response()->json($results);
    }

    public function calculateDiscount(Request $request)
    {
        $request->validate([
            'employeeId' => 'required|exists:employeees,id',
            'baseSalary' => 'required|numeric',
            'subsidies'  => 'required|numeric',
            'workMonth'  => 'required|date_format:Y-m',
        ]);

        $refDate    = Carbon::parse("{$request->workMonth}-01");
        $startDate  = $refDate->copy()->startOfMonth();
        $endDate    = $refDate->copy()->endOfMonth();
        $totalWeekdays = $this->countWeekdays($startDate, $endDate);

        $records = AttendanceRecord::where('employeeId', $request->employeeId)
            ->whereBetween('recordDate', [$startDate->toDateString(), $endDate->toDateString()])
            ->get();

        $presentDays   = $records->where('status', 'Presente')->count();
        $justifiedDays = $records->whereIn('status', ['Férias','Licença','Doença','Teletrabalho'])->count();
        $absentDays    = max(0, $totalWeekdays - ($presentDays + $justifiedDays));

        $dailyRate = $totalWeekdays > 0
            ? ($request->baseSalary + $request->subsidies) / $totalWeekdays
            : 0;

        $discount = round($dailyRate * $absentDays, 2);

        return response()->json([
            'absentDays' => $absentDays,
            'discount'   => $discount,
        ]);
    }

    private function countWeekdays(Carbon $start, Carbon $end)
    {
        $days = 0;
        $current = $start->copy();
        while ($current->lte($end)) {
            if ($current->isWeekday()) $days++;
            $current->addDay();
        }
        return $days;
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $this->formatRequest($request);
        $payment = SalaryPayment::create($data);

        if ($payment->paymentStatus === 'Completed') {
            Mail::to($payment->employee->email)->queue(new SalaryPaidNotification($payment));
        }

        return redirect()->route('salaryPayment.index')
            ->with('msg','Pagamento de salário registrado com sucesso.');
    }

    // ... (os métodos show, edit, update, destroy, pdfAll, pdfPeriod, pdfByEmployee permanecem iguais)

    protected function validateRequest(Request $r)
    {
        $r->validate([
            'employeeId'    =>'required|exists:employeees,id',
            'workMonth'     =>'required|date_format:Y-m',
            'baseSalary'    =>'required|numeric|min:0',
            'subsidies'     =>'required|numeric|min:0',
            'irtRate'       =>'required|numeric|min:0',
            'inssRate'      =>'required|numeric|min:0',
            'discount'      =>'nullable|numeric|min:0',
            'paymentDate'   =>'nullable|date',
            'paymentStatus' =>'required|in:Pending,Completed,Failed',
            'paymentComment'=>'nullable|string',
        ]);
    }

    protected function formatRequest(Request $r)
    {
        $data = $r->all();

        $data['workMonth'] = Carbon::parse($data['workMonth'] . '-01')->toDateString();

        foreach (['baseSalary', 'subsidies', 'irtRate', 'inssRate', 'discount'] as $f) {
            $clean = str_replace('.', '', $data[$f] ?? '0');
            $clean = str_replace(',', '.', $clean);
            $data[$f] = floatval($clean);
        }

        if (empty($data['paymentDate'])) {
            $data['paymentDate'] = Carbon::now()->toDateString();
        }

        $gross   = $data['baseSalary'] + $data['subsidies'];
        $irtVal  = $gross * ($data['irtRate'] / 100);
        $inssVal = $gross * ($data['inssRate'] / 100);
        $discount = $data['discount'] ?? 0;

        $data['salaryAmount'] = round($gross - $irtVal - $inssVal - $discount, 2);

        return $data;
    }

    private function translateStatus(string $status): string
        {
            $map = [
                'Pending'   => 'Pendente',
                'Completed' => 'Concluído',
                'Failed'    => 'Falhou',
            ];

            return $map[$status] ?? $status;
        }
}