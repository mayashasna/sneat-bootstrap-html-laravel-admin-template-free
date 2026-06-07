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
    Schema::create('service_order_ratings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained('service_orders')->onDelete('cascade');
        $table->foreignId('requester_business_id')->constrained('business_accounts')->onDelete('cascade');
        $table->foreignId('provider_business_id')->constrained('business_accounts')->onDelete('cascade');
        $table->unsignedTinyInteger('rating'); // 1 to 5
        $table->text('comment')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_ratings');
    }
};
