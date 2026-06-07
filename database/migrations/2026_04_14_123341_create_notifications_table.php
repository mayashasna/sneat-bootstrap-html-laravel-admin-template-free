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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // صاحب الإشعار (مستخدم التطبيق)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // عنوان الإشعار (مثلاً: تم قبول طلبك)
            $table->string('title');

            // نص الإشعار (مثلاً: تم قبول طلبك على خدمة كذا)
            $table->text('body');

            // نوع الإشعار (اختياري: order_accepted, order_rejected, new_order, rating_added...)
            $table->string('type')->nullable();

            // بيانات إضافية (مثلاً: {"order_id": 5, "service_id": 18})
            $table->json('data')->nullable();

            // هل تمت قراءته؟
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
