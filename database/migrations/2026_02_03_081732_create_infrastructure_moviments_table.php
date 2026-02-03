<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfrastructureMovimentsTable extends Migration
{

    public function up()
    {
        Schema::create('infrastructure_moviments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('infrastructureId');
            $table->foreign('infrastructureId')->references('id')->on('infrastructures')->onDelete('cascade');
            $table->string('type');
            $table->integer('quantity');
            $table->string('document')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('infrastructure_moviments');
    }
}
