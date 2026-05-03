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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('coupon_name');
            $table->string('coupon_quantity');
            $table->string('coupon_ratio');
            $table->string('coupon_code');
            $table->string('description');
            $table->enum('hide',['1','0']);
            $table->enum('status',['1','0']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
