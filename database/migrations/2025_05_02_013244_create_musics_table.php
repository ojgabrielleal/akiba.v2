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
            $table->uuid('uuid')->unique();
            $table->string('type');
            $table->string('production');
            $table->string('image')->nullable();
            $table->string('artist');
            $table->string('name');
            $table->boolean('in_ranking')->default(false);
            $table->string('image_ranking')->nullable();
            $table->integer('song_request_count')->default('0');
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
