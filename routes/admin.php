<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EmployeeeController;
use App\Http\Controllers\Admin\DashboardController;

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
        Route::post("employeee/filter/pdf", [EmployeeeController::class, "pdfFiltered"])->name("employeee.filter.pdf");
    });

    
});
// ====================== Filtros por datas (Funcionários / Estagiários) ======================
    // Funcionários
    Route::get("employeee/filter", [EmployeeeController::class, "filterByDate"])->name("employeee.filter");