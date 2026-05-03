<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupon_usages', function (Blueprint $table) {
            if (!Schema::hasColumn('coupon_usages', 'order_id')) {
                $table->unsignedBigInteger('order_id')->nullable()->after('coupon_id');
                $table->index('order_id');
            }
        });

        Schema::table('coupon_usages', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('coupon_usages', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropIndex(['order_id']);
            $table->dropColumn('order_id');
        });
    }
};
