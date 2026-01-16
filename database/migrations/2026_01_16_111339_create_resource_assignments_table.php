<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeeId');
            $table->foreign('employeeeId')->references('id')->on('employeees')->onDelete('cascade');
            $table->unsignedBigInteger('vehicleId');
            $table->foreign('vehicleId')->references('id')->on('vehicles')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_assignments');
    }
}
