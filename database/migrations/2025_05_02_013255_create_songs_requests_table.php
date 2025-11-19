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
        Schema::create('songs_requests', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_played')->default(false);
            $table->foreignId('onair_id')->constrained('onair')->cascadeOnDelete();
            $table->foreignId('music_id')->constrained('musics')->cascadeOnDelete();
            $table->string('ip');
            $table->string('name');
            $table->string('address');
            $table->string('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs_requests');
    }
};
