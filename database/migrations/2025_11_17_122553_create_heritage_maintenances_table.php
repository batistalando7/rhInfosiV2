<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeritageMaintenancesTable extends Migration
{
    public function up()
    {
        Schema::create('heritage_maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('HeritageId');
            $table->date('MaintenanceDate');
            $table->text('MaintenanceDescription');
            $table->string('MaintenanceResponsible');
            $table->timestamps();

            $table->foreign('HeritageId')->references('id')->on('heritages')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('heritage_maintenances');
    }
}