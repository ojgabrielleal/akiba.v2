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
        Schema::create('onairs', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_playlist')->default(true);
            $table->morphs('show');
            $table->string('image')->nullable();
            $table->string('phrase');
            $table->string('type')->nullable();
            $table->boolean('listener_request_toggle')->default(false);
            $table->integer('listener_request_total')->default(0);
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
