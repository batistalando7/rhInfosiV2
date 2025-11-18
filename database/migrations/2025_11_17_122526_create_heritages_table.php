<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeritagesTable extends Migration
{
    public function up()
    {
        Schema::create('heritages', function (Blueprint $table) {
            $table->id();
            $table->string('Description');
            $table->string('Type');
            $table->decimal('Value', 10, 2);
            $table->date('AcquisitionDate');
            $table->string('Location');
            $table->unsignedBigInteger('ResponsibleId');
            $table->enum('Condition', ['novo', 'usado', 'danificado']);
            $table->text('Observations')->nullable();
            $table->timestamps();

            $table->foreign('ResponsibleId')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('heritages');
    }
}