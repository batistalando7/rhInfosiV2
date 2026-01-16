<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EmployeeeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\RetirementController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\ResourceAssignmentController;

Route::middleware('auth')->name('admin.')->group(function () {

    /* dashboard routes */
    Route::get('/dashboard/filter-by-category/{categoryId}/{academicLevel?}', [DashboardController::class, 'filterByCategory'])->name('dashboard.filterByCategory');
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

    /* department routes */
    Route::prefix('departamentos')->group(function () {

        Route::get('/lista', [DepartmentController::class, 'index'])->name('department.index');
        Route::get('/criar', [DepartmentController::class, 'create'])->name('department.create');
        Route::post('/salvar', [DepartmentController::class, 'store'])->name('department.store');
        Route::get('/editar/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
        Route::put('/atualizar/{id}', [DepartmentController::class, 'update'])->name('department.update');
        Route::get('/detalhes/{id}', [DepartmentController::class, 'show'])->name('department.show');
        Route::get("{id}/delete", [DepartmentController::class, "destroy"])->name("department.destroy");

        //outras rotas de departamento
        Route::get("{departmentId}/pdf", [DepartmentController::class, "employeeePdf"])->name("department.employeee.pdf");
        Route::get("employeee", [DepartmentController::class, "employeee"])->name("department.employeee");
    });



    /* Employee routes */
    Route::prefix('funcionarios')->group(function () {

        Route::get('/lista', [EmployeeeController::class, 'index'])->name('employeee.index');
        Route::get('/criar', [EmployeeeController::class, 'create'])->name('employeee.create');
        Route::post('/salvar', [EmployeeeController::class, 'store'])->name('employeee.store');
        Route::get('/editar/{id}', [EmployeeeController::class, 'edit'])->name('employeee.edit');
        Route::put('/atualizar/{id}', [EmployeeeController::class, 'update'])->name('employeee.update');
        Route::get('/detalhes/{id}', [EmployeeeController::class, 'show'])->name('employeee.show');
        Route::delete('/deletar/{id}', [EmployeeeController::class, 'destroy'])->name('employeee.destroy');

        // filtros

        /* Rota GET com parâmetro ?status=... */
        Route::get("employeee/filter-by-status", [EmployeeeController::class, "filterByStatus"])->name("employeee.filterByStatus");
        /* FIm da Rota GET com parâmetro ?status=... */

        Route::get('/navbar/employee-search', [EmployeeeController::class, 'navbarSearch'])->name('employeee.navbar.search');
        Route::get("employeee/pdf", [EmployeeeController::class, "pdfAll"])->name("employeee.pdfAll");
        Route::get("employeee/{id}/pdf", [EmployeeeController::class, "showPdf"])->name("employeee.showPdf");
        Route::get("employeee/filter", [EmployeeeController::class, "filterByDate"])->name("employeee.filter");
        Route::post("employeee/filter/pdf", [EmployeeeController::class, "pdfFiltered"])->name("employeee.filter.pdf");
    });

    // Estagiários (Intern) routes
    Route::prefix('estagiarios')->group(function () {

        Route::get('/lista', [InternController::class, 'index'])->name('intern.index');
        Route::get('/criar', [InternController::class, 'create'])->name('intern.create');
        Route::post('/salvar', [InternController::class, 'store'])->name('intern.store');
        Route::get('/editar/{id}', [InternController::class, 'edit'])->name('intern.edit');
        Route::put('/atualizar/{id}', [InternController::class, 'update'])->name('intern.update');
        Route::get('/detalhes/{id}', [InternController::class, 'show'])->name('intern.show');
        Route::get('/deletar/{id}', [InternController::class, 'destroy'])->name('intern.destroy');

        /* filtros */
        Route::get("{id}/pdf", [InternController::class, "showPdf"])->name("intern.showPdf");
        Route::get("pdf", [InternController::class, "pdfAll"])->name("intern.pdfAll");
        Route::get("filtros", [InternController::class, "filterByDate"])->name("intern.filter");
        Route::post("filtros/pdf", [InternController::class, "pdfFiltered"])->name("intern.filter.pdf");
    });

    // Reforma (Retirement) routes
    Route::prefix('reformas')->group(function () {

        Route::get('/lista', [RetirementController::class, 'index'])->name('retirements.index');
        Route::get('/criar', [RetirementController::class, 'create'])->name('retirements.create');
        Route::post('/salvar', [RetirementController::class, 'store'])->name('retirements.store');
        Route::get('/editar/{id}', [RetirementController::class, 'edit'])->name('retirements.edit');
        Route::put('/atualizar/{id}', [RetirementController::class, 'update'])->name('retirements.update');
        Route::get('/detalhes/{id}', [RetirementController::class, 'show'])->name('retirements.show');
        Route::delete('/deletar/{id}', [RetirementController::class, 'destroy'])->name('retirements.destroy');

        //filtros
        Route::get("reformas/searchEmployee", [RetirementController::class, "searchEmployee"])->name("retirements.searchEmployee");
        Route::get("reformas/pdf-filtered", [RetirementController::class, "pdfAll"])->name("retirements.exportFilteredPDF");
        Route::get("reformas/pdf", [RetirementController::class, "pdfAll"])->name("retirements.pdf");
    });

    // Viaturas (vehicles) routes
    Route::prefix('veiculos')->group(function () {

        Route::get('/lista', [VehicleController::class, 'index'])->name('vehicles.index');
        Route::get('/criar', [VehicleController::class, 'create'])->name('vehicles.create');
        Route::post('/salvar', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::get('/editar/{vehicle}', [VehicleController::class, 'edit'])->name('vehicles.edit');
        Route::put('/atualizar/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
        Route::get('/detalhes/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
        Route::get('/deletar/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

        //filtros
        Route::get("vehicles/{vehicle}/pdf", [VehicleController::class, "showPdf"])->name("vehicles.showPdf");
        Route::get("pdf", [VehicleController::class, "pdfAll"])->name("vehicles.pdfAll");
        Route::get("pdf-filtered", [VehicleController::class, "exportFilteredPDF"])->name("vehicles.pdfFiltered");
    });

    // Atribuições de Recursos (Resource Assignments) routes
    Route::prefix('atribuicoes')->group(function () {

        Route::get('/lista', [ResourceAssignmentController::class, 'index'])->name('resourceAssignments.index');
        Route::get('/criar', [ResourceAssignmentController::class, 'create'])->name('resourceAssignments.create');
        Route::post('/salvar', [ResourceAssignmentController::class, 'store'])->name('resourceAssignments.store');
        Route::get('/editar/{resourceAssignment}', [ResourceAssignmentController::class, 'edit'])->name('resourceAssignments.edit');
        Route::put('/atualizar/{resourceAssignment}', [ResourceAssignmentController::class, 'update'])->name('resourceAssignments.update');
        Route::get('/detalhes/{resourceAssignment}', [ResourceAssignmentController::class, 'show'])->name('resourceAssignments.show');
        Route::get('/deletar/{resourceAssignment}', [ResourceAssignmentController::class, 'destroy'])->name('resourceAssignments.destroy');

        //filtros
        Route::get('pesquisar/funcionario', [ResourceAssignmentController::class, "searchEmployee"])->name("resourceAssignments.searchEmployee");
        Route::get("atribuicoes/{resourceAssignment}/pdf", [ResourceAssignmentController::class, "showPdf"])->name("resourceAssignments.showPdf");
        Route::get("pdf", [ResourceAssignmentController::class, "pdfAll"])->name("resourceAssignments.pdfAll");
        Route::get("pdf-filtered", [ResourceAssignmentController::class, "exportFilteredPDF"])->name("resourceAssignments.pdfFiltered");
    });

});
