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
        Schema::create('autodj_phrases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('autodj_id')->constrained('autodj')->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->string('phrase');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autodj_phrases');
    }
};
