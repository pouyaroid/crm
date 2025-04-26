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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_agent_id')->nullable()->after('id');
            $table->foreign('sales_agent_id')->references('id')->on('users')->nullOnDelete();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sales_agent_id']);
            $table->dropColumn('sales_agent_id');
            
        });
    }
};
