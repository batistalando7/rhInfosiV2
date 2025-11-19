<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('heritage_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('HeritageId')->constrained('heritages')->onDelete('cascade');
            $table->date('TransferDate');
            $table->text('TransferReason');
            $table->string('TransferResponsible');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('heritage_transfers');
    }
};