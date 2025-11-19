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
                ->with(['employee.department', 'employee.employeeType'])
            : SalaryPayment::with(['employee.department', 'employee.employeeType']);

        if ($request->filled('startDate')) {
            $query->whereDate('paymentDate', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('paymentDate', '<=', $request->endDate);
        }

        $salaryPayments = $query->orderByDesc('created_at')->get();
        $salaryPayments->each(function ($p) {
            $p->paymentStatus = $this->translateStatus($p->paymentStatus);
        });

        return view('salaryPayment.index', [
            'salaryPayments' => $salaryPayments,
            'filters' => $request->only('startDate', 'endDate'),
        ]);
    }

    public function create()
    {
        return view('salaryPayment.create');
    }

    // AJAX para busca de funcionário (com email e IBAN)
    public function searchEmployeeAjax(Request $request)
    {
        $query = $request->get('q', '');
        $employees = Employeee::with('department')
            ->where('fullName', 'LIKE', "%{$query}%")
            ->where('employmentStatus', 'active')
            ->orderBy('fullName')
            ->limit(10)
            ->get();

        $results = $employees->map(function ($e) {
            $dept = $e->department ? $e->department->title : 'Sem departamento';
            return [
                'id'    => $e->id,
                'text'  => $e->fullName,
                'extra' => "Depto: {$dept}",
                'email' => $e->email ?? '',
                'iban'  => $e->iban ?? ''
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

        $refDate   = Carbon::parse("{$request->workMonth}-01");
        $startDate = $refDate->copy()->startOfMonth();
        $endDate   = $refDate->copy()->endOfMonth();
        $totalWeekdays = $this->countWeekdays($startDate, $endDate);

        $records = AttendanceRecord::where('employeeId', $request->employeeId)
            ->whereBetween('recordDate', [$startDate->toDateString(), $endDate->toDateString()])
            ->get();

        $presentDays   = $records->where('status', 'Presente')->count();
        $justifiedDays = $records->whereIn('status', ['Férias', 'Licença', 'Doença', 'Teletrabalho'])->count();
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
            ->with('msg', 'Pagamento de salário registrado com sucesso.');
    }

    public function show($id)
    {
        $salaryPayment = SalaryPayment::with(['employee.department', 'employee.employeeType'])->findOrFail($id);
        $salaryPayment->paymentStatus = $this->translateStatus($salaryPayment->paymentStatus);
        return view('salaryPayment.show', compact('salaryPayment'));
    }

    public function edit($id)
    {
        $salaryPayment = SalaryPayment::findOrFail($id);
        $salaryPayment->paymentStatus = $this->translateStatus($salaryPayment->paymentStatus);
        return view('salaryPayment.edit', compact('salaryPayment'));
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $payment = SalaryPayment::findOrFail($id);
        $data = $this->formatRequest($request);
        $payment->update($data);

        if ($payment->fresh()->paymentStatus === 'Completed') {
            Mail::to($payment->employee->email)->queue(new SalaryPaidNotification($payment));
        }

        return redirect()->route('salaryPayment.index')
            ->with('msg', 'Pagamento de salário atualizado com sucesso.');
    }

    public function destroy($id)
    {
        SalaryPayment::destroy($id);
        return redirect()->route('salaryPayment.index')
            ->with('msg', 'Pagamento de salário removido com sucesso.');
    }

    public function pdfAll()
    {
        $payments = SalaryPayment::with(['employee.department', 'employee.employeeType'])->latest()->get();
        $payments->each(fn($p) => $p->paymentStatus = $this->translateStatus($p->paymentStatus));

        $pdf = PDF::loadView('salaryPayment.salaryPayment_pdf', ['salaryPayments' => $payments])
            ->setPaper('a4', 'landscape');

        return $pdf->stream('RelatorioPagamentosSalarial.pdf');
    }

    public function pdfPeriod(Request $request)
    {
        // Se não vier datas, usa o mês atual
        $startDate = $request->query('startDate');
        $endDate   = $request->query('endDate');

        if (!$startDate || !$endDate) {
            $startDate = now()->startOfMonth()->toDateString();
            $endDate   = now()->endOfMonth()->toDateString();
        }

        $request->merge(['startDate' => $startDate, 'endDate' => $endDate]);

        $payments = SalaryPayment::with(['employee.department', 'employee.employeeType'])
            ->whereBetween('paymentDate', [$startDate, $endDate])
            ->latest()
            ->get();

        $payments->each(fn($p) => $p->paymentStatus = $this->translateStatus($p->paymentStatus));

        $pdf = PDF::loadView('salaryPayment.salaryPayment_period_pdf', [
            'salaryPayments' => $payments,
            'startDate'      => $startDate,
            'endDate'        => $endDate,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream("Pagamentos_{$startDate}_to_{$endDate}.pdf");
    }

    public function pdfByEmployee(Request $request, $employeeId)
    {
        $year  = $request->input('year', now()->year);
        $start = Carbon::create($year, 1, 1);
        $end   = Carbon::create($year, 12, 31);

        $payments = SalaryPayment::with(['employee.department', 'employee.employeeType'])
            ->where('employeeId', $employeeId)
            ->whereBetween('paymentDate', [$start, $end])
            ->orderBy('paymentDate')
            ->get();

        $payments->each(fn($p) => $p->paymentStatus = $this->translateStatus($p->paymentStatus));

        $pdf = PDF::loadView('salaryPayment.salaryPayment_employee_pdf', [
            'payments' => $payments,
            'employee' => Employeee::findOrFail($employeeId),
            'year'     => $year,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream("Salarios_{$employeeId}_{$year}.pdf");
    }

    protected function validateRequest(Request $r)
    {
        $r->validate([
            'employeeId'     => 'required|exists:employeees,id',
            'workMonth'      => 'required|date_format:Y-m',
            'baseSalary'     => 'required|numeric|min:0',
            'subsidies'      => 'required|numeric|min:0',
            'irtRate'        => 'required|numeric|min:0',
            'inssRate'       => 'required|numeric|min:0',
            'discount'       => 'nullable|numeric|min:0',
            'paymentDate'    => 'nullable|date',
            'paymentStatus'  => 'required|in:Pending,Completed,Failed',
            'paymentComment' => 'nullable|string',
        ]);
    }

    protected function formatRequest(Request $r)
{
    $data = $r->all();

    // ... (Conversão de data e limpeza de números - MANTER ESTE CÓDIGO)
    $data['workMonth'] = Carbon::parse($data['workMonth'] . '-01')->toDateString();

    foreach (['baseSalary', 'subsidies', 'irtRate', 'inssRate', 'discount'] as $f) {
        // Assume que a função de limpeza/conversão está no lugar certo
        $clean = str_replace('.', '', $data[$f] ?? '0');
        $clean = str_replace(',', '.', $clean);
        $data[$f] = floatval($clean);
    }
    // ... (Fim da limpeza)

    if (empty($data['paymentDate'])) {
        $data['paymentDate'] = now()->toDateString();
    }

    // 1. Salário Bruto
    $gross = $data['baseSalary'] + $data['subsidies'];
    // 2. Desconto do INSS (Contribuição para a Segurança Social)
    // O INSS é sempre calculado sobre o Salário Bruto (Base de incidência)
    $inssVal = round($gross * ($data['inssRate'] / 100), 2);
    // 3. Matéria Coletável (Base para o IRT)
    // A Matéria Coletável é o Bruto menos o INSS
    $taxableBase = $gross - $inssVal;
    // 4. Desconto do IRT
    // O IRT é calculado sobre a Matéria Coletável.
    // **NOTA IMPORTANTE:** Estamos a usar a taxa fixa ($data['irtRate'])
    // por ser o que o formulário envia.
    // esta linha deveria ser uma função que aplica a tabela progressiva do IRT.
    $irtVal = round($taxableBase * ($data['irtRate'] / 100), 2);
    // 5. Desconto por Faltas/Outros (Desconto Fixo/Variável)
    $discount = $data['discount'] ?? 0;
    // 6. Salário Líquido (Gross - INSS - IRT - Desconto por Faltas)
    $data['salaryAmount'] = round($gross - $inssVal - $irtVal - $discount, 2);

    return $data;
}

    private function translateStatus(string $status): string
    {
        return [
            'Pending'   => 'Pendente',
            'Completed' => 'Concluído',
            'Failed'    => 'Falhou',
        ][$status] ?? $status;
    }
}