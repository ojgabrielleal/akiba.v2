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
            $table->string('slug');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('name')->default('Miyuki Miyazaki');
            $table->string('nickname')->default('Miyu');
            $table->string('avatar')->default("https://i.postimg.cc/XqrFtjpJ/77cdefa9-4158-4a4a-82d0-5dec4ba5a165.png");
            $table->string('email')->default("miyuki@gmail.com");
            $table->string('birthday')->default("2000-01-01");
            $table->string('city')->default("Tokyo");
            $table->string('state')->default("Tokyo");
            $table->string('country')->default("Japan");
            $table->text('bibliography')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->index();
            $table->string('ip_address', 45);
            $table->text('user_agent');
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
