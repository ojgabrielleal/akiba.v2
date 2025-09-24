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
        Schema::table('onair', function (Blueprint $table) {
            $table->dropForeign(['show_id']);
            $table->dropForeign(['autodj_id']);
            $table->dropColumn(['show_id', 'autodj_id', 'category']);
            $table->morphs('program');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onair', function (Blueprint $table) {
            $table->dropMorphs('program');
            $table->string('category');

            $table->unsignedBigInteger('show_id');
            $table->unsignedBigInteger('autodj_id');

            $table->foreign('show_id')->references('id')->on('shows');
            $table->foreign('autodj_id')->references('id')->on('autodj');
        });
    }
};
