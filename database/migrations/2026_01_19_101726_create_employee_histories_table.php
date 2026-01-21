<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeHistoriesTable extends Migration
{

    public function up()
    {
        Schema::create('employee_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeId')->nullable();
            $table->foreign('employeeId')->references('id')->on('employeees')->onDelete('cascade');
            $table->unsignedBigInteger('mobilityId')->nullable();
            $table->foreign('mobilityId')->references('id')->on('mobilities')->onDelete('cascade');
            $table->unsignedBigInteger('leaveRequestId')->nullable();
            $table->foreign('leaveRequestId')->references('id')->on('leave_requests')->onDelete('cascade');
            $table->unsignedBigInteger('extraJobId')->nullable();
            $table->foreign('extraJobId')->references('id')->on('extra_jobs')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_histories');
    }
}
