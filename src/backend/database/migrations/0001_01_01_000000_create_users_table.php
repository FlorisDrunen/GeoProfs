<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('first_name', 255); // Default length is 255
            $table->string('last_name', 255);
            // $table->integer('verlof_saldo')->default(160);
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('rol', ['werknemer', 'teammanager', 'officemanager']);
//            $table->string('phone_number', 15)->nullable();
//            $table->foreignId('team_id')
//                ->nullable()
//                ->constrained('teams')
//                ->onDelete('set null'); // Set to NULL on delete
//            $table->foreignId('role_id')
//                ->nullable()
//                ->constrained('roles')
//                ->onDelete('set null'); // Set to NULL on delete
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 255)->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')
                ->nullable() // Allow NULL values for anonymous sessions
                ->constrained('users');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
