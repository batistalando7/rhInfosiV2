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
        Schema::create('heritage_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('HeritageId')->constrained('heritages')->onDelete('cascade');
            $table->date('TransferDate');
            $table->text('Reason');
            $table->string('ResponsibleName'); // Corrigido: Quem Autorizou/Executou
            $table->string('OriginLocation');
            $table->string('DestinationLocation');
            $table->string('TransferredToName'); // Corrigido: Quem Recebeu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heritage_transfers');
    }
};
