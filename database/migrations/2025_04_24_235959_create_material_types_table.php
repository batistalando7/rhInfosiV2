<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_types', function (Blueprint $table) {
            $table->id();
            // Removida a coluna 'category' e a unique constraint composta
            $table->string('name')->unique(); // 'name' agora é unique por si só
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_types');
    }
};
