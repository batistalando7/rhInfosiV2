<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VacationRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DirectorGeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Lista pedidos encaminhados pelo RH
    public function pendingVacations(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'director' && $user->role !== 'admin') {
            abort(403, 'Acesso negado.');
        }

        $from = $request->input('from');
        $to   = $request->input('to');

        $query = VacationRequest::where('approvalStatus', 'Encaminhado');

        if ($from && $to) {
            $query->whereBetween('created_at', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay(),
            ]);
        }

        $pendingRequests = $query->with('employee')->orderByDesc('id')->get();

        return view('directorGeneral.pendingVacations', compact('pendingRequests', 'from', 'to'));
    }

    // Aprovação Final pelo Diretor Geral
    public function approveVacation($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'director' && $user->role !== 'admin') {
            abort(403, 'Acesso negado.');
        }

        $vacation = VacationRequest::with('employee.department', 'employee.position')->findOrFail($id);
        
        $vacation->approvalStatus = 'Aprovado';
        $vacation->approvalComment = $request->input('approvalComment') ?? 'Aprovado pelo Diretor Geral';
        
        // Geração do PDF assinado
        $pdf = PDF::loadView('departmentHead.employeeVacationPdf', [
            'employee'  => $vacation->employee,
            'vacations' => [$vacation],
            'showSignature' => true // Flag para mostrar a sign.png
        ])->setPaper('a4', 'portrait');

        $fileName = 'Ferias_Assinada_' . $vacation->id . '_' . time() . '.pdf';
        $path = 'signed_vacations/' . $fileName;
        
        Storage::disk('public')->put($path, $pdf->output());
        
        $vacation->signedPdfPath = $path;
        $vacation->save();

        return redirect()->route('admin.director.pendingVacations')
            ->with('msg', 'Pedido de férias aprovado e assinado com sucesso!');
    }

    // Rejeição pelo Diretor Geral
    public function rejectVacation($id, Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'director' && $user->role !== 'admin') {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'rejectionReason' => 'required|string|min:5'
        ]);

        $vacation = VacationRequest::findOrFail($id);
        $vacation->approvalStatus = 'Recusado';
        $vacation->rejectionReason = $request->rejectionReason;
        $vacation->approvalComment = 'Recusado pelo Diretor Geral: ' . $request->rejectionReason;
        $vacation->save();

        return redirect()->route('admin.director.pendingVacations')
            ->with('msg', 'Pedido de férias recusado.');
    }
}
