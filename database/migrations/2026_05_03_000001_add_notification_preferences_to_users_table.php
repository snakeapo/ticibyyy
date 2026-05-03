<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notify_new_products')->default(true);
            $table->boolean('notify_stock_updates')->default(true);
            $table->boolean('notify_order_updates')->default(true);
            $table->boolean('notify_coupon_updates')->default(true);
            $table->boolean('notify_price_drops')->default(true);
            $table->boolean('notify_question_answers')->default(true);
            $table->boolean('notify_abandoned_cart')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'notify_new_products',
                'notify_stock_updates',
                'notify_order_updates',
                'notify_coupon_updates',
                'notify_price_drops',
                'notify_question_answers',
                'notify_abandoned_cart',
            ]);
        });
    }
};
