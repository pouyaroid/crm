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
        Schema::create('customer_calls', function (Blueprint $table) {
    $table->id();
    $table->foreignId('customer_info_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // کسی که تماس رو ثبت کرده
    $table->string('title')->nullable(); // موضوع تماس
    $table->text('description')->nullable(); // توضیح تماس
    $table->timestamp('called_at')->nullable(); // زمان تماس
    $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_calls');
    }
};
