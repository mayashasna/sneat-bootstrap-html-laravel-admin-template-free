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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();

            // 🔥 Morph Columns (مهمين جداً)
            $table->unsignedBigInteger('dynamic_fieldable_id')->nullable();
            $table->string('dynamic_fieldable_type')->nullable();

            // 🔥 Names
            $table->string('name_ar');
            $table->string('name_en');

            // 🔥 Field Type
            $table->string('type'); // text, number, select, checkbox, radio, date...

            // 🔥 Options
            $table->boolean('is_required')->default(false);
            $table->boolean('is_filterable')->default(false);
            $table->boolean('is_active')->default(true);

            // 🔥 Sorting
            $table->integer('sort_order')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
