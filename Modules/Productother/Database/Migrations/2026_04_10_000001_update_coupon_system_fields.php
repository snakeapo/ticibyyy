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
        Schema::table('coupons', function (Blueprint $table) {
            if (!Schema::hasColumn('coupons', 'discount_type')) {
                $table->enum('discount_type', ['fixed', 'percent'])->default('fixed')->after('coupon_ratio');
            }

            if (!Schema::hasColumn('coupons', 'coupon_scope')) {
                $table->enum('coupon_scope', ['product', 'cart', 'both'])->default('both')->after('discount_type');
            }
        });

        Schema::table('baskets', function (Blueprint $table) {
            if (!Schema::hasColumn('baskets', 'coupon_id')) {
                $table->unsignedBigInteger('coupon_id')->nullable()->after('basket_token');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baskets', function (Blueprint $table) {
            if (Schema::hasColumn('baskets', 'coupon_id')) {
                $table->dropColumn('coupon_id');
            }
        });

        Schema::table('coupons', function (Blueprint $table) {
            if (Schema::hasColumn('coupons', 'coupon_scope')) {
                $table->dropColumn('coupon_scope');
            }

            if (Schema::hasColumn('coupons', 'discount_type')) {
                $table->dropColumn('discount_type');
            }
        });
    }
};
