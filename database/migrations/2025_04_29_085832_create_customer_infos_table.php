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
            $table->string('email');
            $table->string('ceo');
            $table->string('address');
            $table->string('bank');
            $table->text('note');
            $table->integer('account_number');
            $table->integer('company_phone');
            $table->integer('mobile_phone');
            $table->integer('postal_code');
            $table->integer('id_meli');
            $table->integer('code_eghtesadi');
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
