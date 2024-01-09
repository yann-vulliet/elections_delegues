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
            $table->id();
            $table->string('lastName');
            $table->string('firstName');
            $table->string('discord')->nullable();
            $table->string('address');
            $table->string('zipCode');
            $table->string('city');
            $table->string('avatar');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->timestamp('vote1')->nullable();
            $table->timestamp('vote2')->nullable();
            $table->integer('result1')->default(0);
            $table->integer('result2')->default(0);

            $table->foreignId('role_id')->nullable()->default(null)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
