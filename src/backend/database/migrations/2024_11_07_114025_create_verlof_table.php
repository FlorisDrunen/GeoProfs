<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerlofTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verlof', function (Blueprint $table) {
            $table->id('VerlofID'); // Unieke primaire sleutel
            $table->time('BeginTijd'); // Begin tijd
            $table->date('BeginDatum'); // Begin datum
            $table->time('EindTijd'); // Eind tijd
            $table->date('EindDatum'); // Eind datum
            $table->string('Reden'); // Reden voor het verlof
            $table->timestamps(); // Tijd aangepast door gebruiker
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verlof');
    }
}
