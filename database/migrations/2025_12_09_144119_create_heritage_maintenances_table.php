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
        Schema::create('heritage_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('HeritageId')->constrained('heritages')->onDelete('cascade');
            $table->date('MaintenanceDate');
            $table->text('Description');
            $table->string('ResponsibleName'); // Corrigido: Campo de texto para o nome do responsável
            $table->decimal('MaintenanceCost', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heritage_maintenances');
    }
};
