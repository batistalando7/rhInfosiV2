<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('heritages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->string('model')->nullable();
            $table->date('manufactureDate')->nullable();
            $table->unsignedBigInteger('heritageTypeId');
            $table->foreign('heritageTypeId')->references('id')->on('heritage_types')->onDelete('cascade');
            $table->unsignedBigInteger('supplierId');
            $table->foreign('supplierId')->references('id')->on('suppliers')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->string('document')->nullable(); // Novo: Para o documento de aquisição
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heritages');
    }
};
