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
            $table->boolean('listener_request_status')->default(false);
            $table->integer('listener_request_total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onair', function (Blueprint $table) {
            $table->dropColumn('listener_request_status')->default(false);
            $table->dropColumn('listener_request_total')->default(0);
        });
    }
};
