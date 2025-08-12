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
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('remindable'); // برای اتصال به مدل‌های مختلف
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('remind_at');
            $table->boolean('is_notified')->default(false); // فقط یک بار نوتیف ارسال بشه
            $table->timestamps();
    
            //  ایندکس ترکیبی برای بهبود عملکرد کوئری‌ها
            $table->index(['remind_at', 'is_notified']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
