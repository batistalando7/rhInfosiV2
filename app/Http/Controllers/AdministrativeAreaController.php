<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VacationRequest;
use Carbon\Carbon;

class AdministrativeAreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Lista pedidos validados pelo chefe de departamento
    public function pendingVacations(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'hr'])) {
            abort(403, 'Acesso negado.');
        }

        $from = $request->input('from');
        $to   = $request->input('to');
        $employeeId = $request->input('employeeId');

        $query = VacationRequest::where('approvalStatus', 'Validado');

        if ($from && $to) {
            $query->whereBetween('created_at', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay(),
            ]);
        }

        if ($employeeId) {
            $query->where('employeeId', $employeeId);
        }

        $pendingRequests = $query->with('employee')->orderByDesc('id')->get();

        return view('administrativeArea.pendingVacations', compact('pendingRequests', 'from', 'to', 'employeeId'));
    }

    // Encaminha o pedido para o Diretor Geral
    public function forwardVacation($id, Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'hr'])) {
            abort(403, 'Acesso negado.');
        }

        $vacation = VacationRequest::findOrFail($id);
        
        // Retificação de datas se fornecidas
        if ($request->filled('vacationStart')) {
            $vacation->vacationStart = $request->vacationStart;
            
            // Recalcular data de fim baseada no tipo de férias
            $start = Carbon::parse($request->vacationStart);
            $needed = intval(explode(' ', $vacation->vacationType)[0]);
            $holidays = $vacation->manualHolidays ?? [];

            $end = $start->copy();
            $count = 0;
            while($count < $needed) {
                $end->addDay();
                if ($end->isWeekend()) continue;
                if (in_array($end->toDateString(), $holidays)) continue;
                $count++;
            }
            if ($end->isWeekend()) {
                $end->next(Carbon::MONDAY);
            }
            $vacation->vacationEnd = $end->toDateString();
        }

        $vacation->approvalStatus = 'Encaminhado';
        $vacation->approvalComment = $request->input('approvalComment') ?? 'Encaminhado pela Área Administrativa';
        $vacation->save();

        return redirect()->route('admin.hr.pendingVacations')
            ->with('msg', 'Pedido de férias encaminhado para o Diretor Geral com sucesso!');
    }
}
