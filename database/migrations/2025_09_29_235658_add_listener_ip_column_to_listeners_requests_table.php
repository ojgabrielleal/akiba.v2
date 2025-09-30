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
        Schema::table('listeners_requests', function (Blueprint $table) {
            $table->string('listener_ip')->after('listener');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listeners_requests', function (Blueprint $table) {
            $table->dropColumn('listener_ip');
        });
    }
};
