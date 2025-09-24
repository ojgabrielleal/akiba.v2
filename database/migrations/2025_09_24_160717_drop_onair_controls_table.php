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
        Schema::dropIfExists('onair_controls');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // recriar a tabela caso queira rollback
        Schema::create('onair_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('onair_id')->constrained('onair')->cascadeOnDelete();
            $table->boolean('listener_request_status')->default(false);
            $table->integer('listener_request_count')->default(0);
            $table->timestamps();
        });
    }
};
