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
    Schema::table('services', function (Blueprint $table) {
        $table->softDeletes(); // 🔥 هذا بيضيف عمود deleted_at
    });
}

public function down()
{
    Schema::table('services', function (Blueprint $table) {
        $table->dropSoftDeletes(); // 🔥 هذا بيحذف العمود إذا عملت rollback
    });
}

};
