<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EmployeeeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\RetirementController;

Route::middleware('auth')->name('admin.')->group(function () {

    /* dashboard routes */
    Route::get('/dashboard/filter-by-category/{categoryId}/{academicLevel?}', [DashboardController::class, 'filterByCategory'])->name('dashboard.filterByCategory');
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");


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
});
