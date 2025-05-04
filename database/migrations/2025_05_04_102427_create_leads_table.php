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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
    $table->string('name');
    $table->string('phone');
    $table->string('company')->nullable();
    $table->string('source')->nullable();
    $table->enum('interest_level', ['کم', 'متوسط', 'زیاد'])->default('متوسط');
    $table->text('note')->nullable();
    $table->enum('status', ['در انتظار تماس', 'تماس گرفته شد', 'تبدیل به مشتری شد'])->default('در انتظار تماس');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
