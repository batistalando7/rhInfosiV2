<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('heritages', function (Blueprint $table) {
            $table->id();
            $table->string('Description');
            $table->string('Type');
            $table->decimal('Value', 12, 2);
            $table->date('AcquisitionDate');
            $table->string('Location');
            $table->unsignedBigInteger('ResponsibleId'); // Aponta para admins.id
            $table->enum('Condition', ['novo', 'usado', 'danificado']);
            $table->text('Observations')->nullable();

            // Dados de quem preencheu o formulário
            $table->string('FormResponsibleName');
            $table->string('FormResponsiblePhone')->nullable();
            $table->string('FormResponsibleEmail');
            $table->date('FormDate');

            $table->timestamps();

            // CORRETO: aponta para a tabela admins (não users!)
            $table->foreign('ResponsibleId')
                  ->references('id')
                  ->on('admins')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('heritages');
    }
};