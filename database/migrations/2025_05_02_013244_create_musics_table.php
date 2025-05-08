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
        Schema::create('musics', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('production')->nullable();
            $table->string('singer')->nullable();
            $table->string('music')->nullable();
            $table->string('album')->nullable();
            $table->string('cover')->nullable();
            $table->string('max_solicitation')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musics');
    }
};
