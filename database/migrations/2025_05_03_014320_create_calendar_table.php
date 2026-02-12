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
        Schema::create('calendar', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->boolean('is_active')->default(true);
            $table->boolean('has_activity')->default(false);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('activities')->cascadeOnDelete();
            $table->time('time');
            $table->date('date');
            $table->string('category');
            $table->string('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar');
    }
};
