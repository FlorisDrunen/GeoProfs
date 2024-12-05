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
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->time('begin_tijd');
            $table->date('begin_datum');
            $table->time('eind_tijd');
            $table->date('eind_datum');
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');
            $table->text('reden')->nullable();
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
        Schema::dropIfExists('verlof');
    }
}
