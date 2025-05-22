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
        Schema::create('listeners_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('onair_id')->constrained('onair')->cascadeOnDelete();
            $table->foreignId('music_id')->constrained('musics')->cascadeOnDelete();
            $table->string('listener');
            $table->string('address');
            $table->string('message');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listeners_requests');
    }
};
