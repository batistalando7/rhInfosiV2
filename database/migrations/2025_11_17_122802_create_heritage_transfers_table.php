<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeritageTransfersTable extends Migration
{
    public function up()
    {
        Schema::create('heritage_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('HeritageId');
            $table->date('TransferDate');
            $table->text('TransferReason');
            $table->string('TransferResponsible');
            $table->timestamps();

            $table->foreign('HeritageId')->references('id')->on('heritages')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('heritage_transfers');
    }
}