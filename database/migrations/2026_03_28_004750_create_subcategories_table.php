<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();

            // التصنيف الرئيسي المرتبط فيه هاد التصنيف الفرعي
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            // اسم التصنيف الفرعي بالعربي
            $table->string('name_ar');

            // اسم التصنيف الفرعي بالإنجليزي
            $table->string('name_en');




            // تفعيل/تعطيل التصنيف الفرعي
            $table->boolean('is_active')->default(true);

            // ترتيب عرض التصنيف الفرعي

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
