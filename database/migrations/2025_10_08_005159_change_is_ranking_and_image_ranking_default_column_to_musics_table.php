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
        Schema::table('musics', function (Blueprint $table) {
            $table->string('image_ranking')->default('#')->change();
            $table->boolean('is_ranking')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('musics', function (Blueprint $table) {
            $table->boolean('is_ranking')->default(null)->change(); // ou ->default(0)
            $table->string('image_ranking')->default(null)->change();
        });
    }
};
