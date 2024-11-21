<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusIdToVerlofTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('verlof', function (Blueprint $table) {
            $table->unsignedBigInteger('StatusID')->nullable(); // StatusID als foreign key
            $table->foreign('StatusID')->references('StatusID')->on('status')->onDelete('set null'); // Cascade verwijderen
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('verlof', function (Blueprint $table) {
            $table->dropForeign(['StatusID']);
            $table->dropColumn('StatusID');
        });
    }
}
