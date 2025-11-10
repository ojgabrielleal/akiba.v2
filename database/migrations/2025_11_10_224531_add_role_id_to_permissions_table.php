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
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['user_id']); 
            $table->dropColumn('user_id');
            $table->foreignId('role_id')->after('id')->constrained('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['role_id']); 
            $table->dropColumn('role_id');
            $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
        });
    }
};