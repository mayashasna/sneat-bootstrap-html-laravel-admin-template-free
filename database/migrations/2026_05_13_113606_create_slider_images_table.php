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
    Schema::create('slider_images', function (Blueprint $table) {
        $table->id();
        $table->string('path');          // مسار الصورة داخل storage/slider/...
        $table->timestamp('created_at')->useCurrent(); // وقت الإضافة
    });
}


    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::dropIfExists('slider_images');
}

};
