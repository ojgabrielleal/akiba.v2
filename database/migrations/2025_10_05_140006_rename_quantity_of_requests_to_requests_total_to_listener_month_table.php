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
        Schema::table('listener_month', function (Blueprint $table) {
            $table->renameColumn('quantity_of_requests', 'requests_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listener_month', function (Blueprint $table) {
            $table->renameColumn('requests_total', 'quantity_of_requests');
        });
    }
};
