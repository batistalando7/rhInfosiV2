<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Employeee;
use App\Models\LeaveType;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with('drivers', 'maintenance');
        if ($request->filled('startDate')) {
            $query->whereDate('created_at', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('created_at', '<=', $request->endDate);
        }
        $vehicles = $query->orderByDesc('id')->get();
        return view('admin.vehicles.list.index', compact('vehicles'));
    }

    public function create()
    {
        /* $drivers = Driver::where('status', 'Active')->get(); */
        $employeee = Employeee::orderBy('fullName')->get();
        return view('admin.vehicles.create.index', compact('employeee'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plate' => 'required|string|max:12|unique:vehicles',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'yearManufacture' => 'required|integer|min:1900|max:' . date('Y'),
            'color' => 'required|string|max:30',
            'loadCapacity' => 'required|integer|min:1',
            'status' => 'required|in:Available,UnderMaintenance,Unavailable',
            'driverId' => 'nullable|exists:drivers,id',
            'notes' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $vehicle = Vehicle::create($data);

        if ($request->filled('driverId')) {
            $vehicle->drivers()->attach($request->driverId, ['startDate' => now()]);
        }

        return redirect()->route('admin.vehicles.index')->with('msg', 'Viatura cadastrada com sucesso.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('drivers', 'maintenance');
        return view('admin.vehicles.details.index', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $employeee = Employeee::orderBy('fullName')->get();
        return view('admin.vehicles.edit.index', compact('vehicle', 'employeee'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'plate' => 'required|string|max:12|unique:vehicles,plate,' . $vehicle->id,
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'yearManufacture' => 'required|integer|min:1900|max:' . date('Y'),
            'color' => 'required|string|max:30',
            'loadCapacity' => 'required|integer|min:1',
            'status' => 'required|in:Available,UnderMaintenance,Unavailable',
            'driverId' => 'nullable|exists:drivers,id',
            'notes' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $vehicle->update($data);

        if ($request->filled('driverId') && $request->driverId != $vehicle->driverId) {
            // Lógica para trocar driver se necessário
            $vehicle->drivers()->detach();
            $vehicle->drivers()->attach($request->driverId, ['startDate' => now()]);
        }

        return redirect()->route('admin.vehicles.edit', $vehicle)->with('msg', 'Viatura atualizada com sucesso.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->drivers()->detach();
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('msg', 'Viatura excluída com sucesso.');
    }

    // PDFs (similar a outros; adicione filtros se quiser)
    public function pdfAll(Request $request)
    {
        $query = Vehicle::with('drivers', 'maintenance');
        if ($request->filled('startDate')) {
            $query->whereDate('created_at', '>=', $request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('created_at', '<=', $request->endDate);
        }
        $filtered = $query->orderByDesc('id')->get();

        $filename = 'Viaturas' . (
            $request->filled('startDate') || $request->filled('endDate')
            ? '_Filtradas' : ''
        ) . '.pdf';

        $pdf = PDF::loadView('pdf.vehicles.vehicles_pdf', compact('filtered'))->setPaper('a4', 'portrait');
        return $pdf->stream($filename);
    }

    public function showPdf(Vehicle $vehicle)
    {
        $vehicle->load('drivers', 'maintenance');
        $pdf = PDF::loadView('pdf.vehicles.vehicle_pdf_individual', compact('vehicle'))->setPaper('a4', 'portrait');
        return $pdf->stream("Viatura_{$vehicle->id}.pdf");
    }

}