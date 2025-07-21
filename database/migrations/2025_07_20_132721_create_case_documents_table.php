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
        Schema::create('case_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_case_id')->constrained('customer_cases')->onDelete('cascade');
            $table->string('file_type'); // کارت ملی، اجاره نامه، قرارداد و...
            $table->string('file_path');
            $table->string('uploaded_by')->nullable(); // مثلاً user_id اگر خواستی
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_documents');
    }
};
