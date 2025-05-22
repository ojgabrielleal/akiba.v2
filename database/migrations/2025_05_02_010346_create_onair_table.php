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
            $table->foreignId('show_id')->constrained('shows')->cascadeOnDelete()->nullable();
            $table->foreignId('autodj_id')->constrained('autodj')->cascadeOnDelete()->nullable();
            $table->string('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onairs');
    }
};
