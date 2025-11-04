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
        Schema::table('users', function (Blueprint $table) {
             $table->string('name')->nullable()->change();
            $table->string('nickname')->nullable()->change();
            $table->string('avatar')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('birthday')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->text('bibliography')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->default('Miyuki Miyazaki')->change();
            $table->string('nickname')->default('Miyu')->change();
            $table->string('avatar')->default("https://i.postimg.cc/XqrFtjpJ/77cdefa9-4158-4a4a-82d0-5dec4ba5a165.png");
            $table->string('email')->default("miyuki@gmail.com")->change();
            $table->string('birthday')->default("2000-01-01")->change();
            $table->string('city')->default("Tokyo")->change();
            $table->string('state')->default("Tokyo")->change();
            $table->string('country')->default("Japan")->change();
            $table->text('bibliography')->nullable()->change();
        });
    }
};
