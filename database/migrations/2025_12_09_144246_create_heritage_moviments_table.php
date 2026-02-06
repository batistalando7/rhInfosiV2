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
        Schema::create('heritage_moviments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('heritageId');
            $table->foreign('heritageId')->references('id')->on('heritages')->onDelete('cascade');
            $table->string('type');
            $table->integer('quantity');
            $table->date('date')->nullable();
            $table->string('responsible')->nullable(); // Corrigido: Quem Autorizou/Executou
            $table->string('destiny')->nullable();
            $table->string('notes')->nullable();
            $table->string('document')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heritage_moviments');
    }
};
