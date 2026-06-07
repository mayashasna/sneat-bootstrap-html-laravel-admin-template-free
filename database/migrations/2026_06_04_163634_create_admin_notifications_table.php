<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();

            // عنوان الإشعار (مثلاً: خدمة جديدة بحاجة مراجعة)
            $table->string('title');

            // نص الإشعار
            $table->text('body');

            // نوع الإشعار (new_business_account, new_service, new_order ...)
            $table->string('type')->nullable();

            // بيانات إضافية (مثلاً: {"service_id": 5, "business_id": 3})
            $table->json('data')->nullable();

            // هل تمت قراءته؟
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
