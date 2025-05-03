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
        Schema::create('customer_infos', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_type');
            $table->string('personal_name');
            $table->string('email')->unique();
            $table->string('ceo');
            $table->string('address');
            $table->string('bank');
            $table->text('note')->nullable(); // برای اجتناب از خطای null
            $table->string('account_number', 20); // شماره حساب بلند
            $table->string('company_phone', 20); // شماره تلفن ثابت
            $table->string('mobile_phone', 20); // شماره موبایل
            $table->string('postal_code', 20);
            $table->string('id_meli', 20); // کد ملی
            $table->string('code_eghtesadi', 20); // کد اقتصادی
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_infos');
    }
};
