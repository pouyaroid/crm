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
        Schema::table('complaint_responses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); // اضافه کردن ستون user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // ایجاد foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaint_responses', function (Blueprint $table) {
            //
        });
    }
};
