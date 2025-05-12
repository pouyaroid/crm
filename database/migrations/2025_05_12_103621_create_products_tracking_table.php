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
        Schema::create('products_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique();
            $table->enum('status', ['انبار','درحال ارسال','ارسال شد' ,'درحال تولید', 'آماده سازی'])->default('آماده سازی');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_tracking');
    }
};
