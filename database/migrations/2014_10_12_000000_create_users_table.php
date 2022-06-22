<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->enum('role', User::$roles);
            $table->string('avatar', 1000)->nullable();
            $table->string('stripe')->nullable();
            $table->boolean('is_sub')->default(false);
            $table->timestamps();
        });

        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(User::class)->constrained();
            $table->string('avatar')->nullable();
            $table->string('name');
            $table->text('payload');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
        Schema::dropIfExists('users');
    }
};
