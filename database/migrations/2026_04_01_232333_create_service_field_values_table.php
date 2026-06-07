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
    Schema::create('service_field_values', function (Blueprint $table) {
        $table->id();
        $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
        $table->foreignId('field_id')->constrained('fields')->onDelete('cascade');
        $table->text('value')->nullable(); // القيمة المدخلة (نص/رقم/خيار)
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('service_field_values');
}

};
