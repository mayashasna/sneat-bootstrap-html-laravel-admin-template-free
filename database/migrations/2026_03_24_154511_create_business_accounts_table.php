<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('business_accounts', function (Blueprint $table) {
            $table->id();

            // علاقات
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('activity_type_id')->constrained('activity_types')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');

            // بيانات الحساب
            $table->string('license_number')->nullable();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('activities')->nullable();
            $table->text('details')->nullable();

            // الموقع
            $table->string('latitude');
            $table->string('longitude');

            // ملفات
            $table->json('documents')->nullable();

            // الحالة
            $table->string('status')->default('Pending');

            $table->timestamps();

            // 🔥 أهم شي: منع تكرار نفس النشاط لنفس اليوزر
            $table->unique(['user_id', 'activity_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_accounts');
    }
};
