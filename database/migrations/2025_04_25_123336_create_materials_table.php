<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            // Removida a coluna 'Category'
            $table->unsignedBigInteger('materialTypeId');
            $table->string('Name');
            $table->string('SerialNumber')->unique();
            $table->string('Model');
            $table->date('ManufactureDate');
            $table->string('SupplierName');
            $table->string('SupplierIdentifier');
            $table->date('EntryDate');
            $table->integer('CurrentStock')->default(0);
            $table->text('Notes')->nullable();
            $table->timestamps();

            $table->foreign('materialTypeId')
                  ->references('id')
                  ->on('material_types')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
