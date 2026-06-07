<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('services', function (Blueprint $table) {
        $table->id();

        // علاقات
        $table->foreignId('business_id')->constrained('business_accounts')->cascadeOnDelete();
        $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
        $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->nullOnDelete();

        // بيانات أساسية
        $table->string('title_ar');
        $table->string('title_en');
        $table->text('description_ar');
        $table->text('description_en');

        // الكمية المتاحة
        $table->integer('quantity')->default(1);

        // نوع الخدمة
        $table->enum('type', ['sale', 'rent']);

        // السعر + العملة
        $table->decimal('price', 10, 2);
        $table->enum('currency', ['SYP', 'USD']);

        // الموقع
        $table->string('location_text')->nullable();
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();

        // الحالة
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
