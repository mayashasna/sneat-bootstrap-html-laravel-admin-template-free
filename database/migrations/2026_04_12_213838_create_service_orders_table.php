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
    Schema::create('service_orders', function (Blueprint $table) {
        $table->id();

        // الخدمة المطلوبة
        $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();

        // حساب الأعمال الطالب (اللي عم يطلب الخدمة)
        $table->foreignId('requester_business_id')
            ->constrained('business_accounts')
            ->cascadeOnDelete();

        // حساب الأعمال المقدم (صاحب الخدمة) – من service.business_id
        $table->foreignId('provider_business_id')
            ->constrained('business_accounts')
            ->cascadeOnDelete();

        // الكمية المطلوبة
        $table->unsignedInteger('quantity')->default(1);

        // وقت الاحتياج (اختياري)
        $table->timestamp('needed_at')->nullable();

        // تفاصيل إضافية من الطالب
        $table->text('details')->nullable();

        // حالة الطلب: pending / accepted / rejected
        $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
