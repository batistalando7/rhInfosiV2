<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfrastructuresTable extends Migration
{

    public function up()
    {
        Schema::create('infrastructures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('serialNumber')->nullable();
            $table->string('model')->nullable();
            $table->integer('quantity');
            $table->date('manufactureDate')->nullable();
            $table->date('entryDate');
            $table->string('notes')->nullable();
            $table->string('document')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('supplierId');
            $table->foreign('supplierId')->references('id')->on('suppliers')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('infrastructures');
    }
}
