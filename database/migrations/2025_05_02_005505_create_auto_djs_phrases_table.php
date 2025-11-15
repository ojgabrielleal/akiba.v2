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
        Schema::create('auto_djs_phrases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auto_dj_id')->constrained('auto_djs')->cascadeOnDelete();
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
        Schema::dropIfExists('auto_djs_phrases');
    }
};
