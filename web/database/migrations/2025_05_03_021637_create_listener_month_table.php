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
        Schema::create('listener_month', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('listener_name');
            $table->string('address');
            $table->string('favorite_program');
            $table->string('quantity_of_requests');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listener_months');
    }
};
