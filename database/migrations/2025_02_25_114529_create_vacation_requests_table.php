<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('vacation_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeId');
            $table->string('vacationType'); 

            $table->date('vacationStart');
            $table->date('vacationEnd');

            $table->text('reason')->nullable();

            $table->json('manualHolidays')->nullable();  // novos feriados/tolerâncias
            $table->string('supportDocument')->nullable();
            $table->string('originalFileName')->nullable();

            $table->string('approvalStatus')->default('Pendente'); // Pendente, Validado, Encaminhado, Aprovado, Recusado
            $table->string('approvalComment')->nullable();
            $table->string('rejectionReason')->nullable(); // Justificativa do Diretor Geral
            $table->string('signedPdfPath')->nullable(); // Caminho do PDF assinado

            $table->timestamps();

            $table->foreign('employeeId')
                  ->references('id')
                  ->on('employeees')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacation_requests');
    }
}
