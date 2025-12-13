<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('material_transactions', function (Blueprint $table) {
            // Adiciona a FK CreatedBy
            $table->foreign('CreatedBy')
                  ->references('id')
                  ->on('employeees')
                  ->onDelete('set null');
                  
            // Adiciona a FK DepartmentId
            $table->foreign('DepartmentId')
                  ->references('id')
                  ->on('departments')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('material_transactions', function (Blueprint $table) {
            $table->dropForeign(['CreatedBy']);
            $table->dropForeign(['DepartmentId']);
        });
    }
};
