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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('token', 64)->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->json('abilities');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('source')->nullable();
            $table->string('ip', 300)->nullable();
            $table->string('agent')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();

            $table->primary('token');
        });

        Schema::create('attempts', function (Blueprint $table) {
            $table->string('token', 64)->unique();
            $table->json('action')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('ip', 300)->nullable();
            $table->string('agent')->nullable();
            $table->timestamps();

            $table->primary('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('attempts');
    }
};
