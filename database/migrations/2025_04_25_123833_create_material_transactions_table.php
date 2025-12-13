<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('MaterialId');
            $table->enum('TransactionType', ['in','out']);
            $table->date('TransactionDate');
            $table->integer('Quantity');
            $table->string('OriginOrDestination');
            $table->string('DocumentationPath')->nullable();
            $table->text('Notes')->nullable();
            $table->unsignedBigInteger('DepartmentId')->nullable();
            $table->unsignedBigInteger('CreatedBy')->nullable();
            $table->timestamps();

            // Apenas a FK para 'materials' é criada aqui
            $table->foreign('MaterialId')
                  ->references('id')->on('materials')
                  ->cascadeOnDelete();
            
            // As FKs para 'departments' e 'employeees' serão adicionadas na próxima migration
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_transactions');
    }
};