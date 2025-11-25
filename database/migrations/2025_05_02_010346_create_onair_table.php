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
        Schema::create('onair', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_playlist')->default(true);
            $table->morphs('show');
            $table->string('image')->nullable();
            $table->string('phrase');
            $table->string('type')->nullable();
            $table->boolean('song_request_status')->default(false);
            $table->integer('song_request_total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onair');
    }
};
