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
        Schema::table('onair_controls', function (Blueprint $table) {
            $table->dropColumn('listener_request_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onair_controls', function (Blueprint $table) {
            $table->integer('listener_request_count')->default(0);
        });
    }
};
