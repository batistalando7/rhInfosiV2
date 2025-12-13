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
            $table->foreignId('heritageTypeId')->constrained('heritage_types');
            $table->string('Description');
            $table->decimal('Value', 10, 2); // Valor do Património
            $table->date('AcquisitionDate');
            $table->string('Location');
            $table->string('ResponsibleName'); // Corrigido: Campo de texto para o nome do responsável
            $table->string('Condition'); // Novo, Usado, Danificado, etc.
            $table->text('Notes')->nullable();
            $table->string('DocumentationPath')->nullable(); // Novo: Para o documento de aquisição
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
