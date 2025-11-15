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
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->string('slug');
            $table->boolean('has_schedule');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name')->unique();
            $table->string('image');
            $table->boolean('is_all');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shows');
    }
};
