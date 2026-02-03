eve<?php

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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('cover')->nullable();
            $table->string('image')->nullable();
            $table->string('slug');
            $table->string('title');
            $table->longText('content');
            $table->string('dates');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
