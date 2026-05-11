<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->boolean('requires_balance')->default(true)->after('title');
        });

        Schema::table('auction_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('cargo_id')->nullable()->after('address_snapshot');
            $table->decimal('cargo_price', 12, 2)->default(0)->after('cargo_id');
            $table->string('payment_method')->nullable()->after('cargo_price');
            $table->timestamp('checkout_completed_at')->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('auction_orders', function (Blueprint $table) {
            $table->dropColumn(['cargo_id', 'cargo_price', 'payment_method', 'checkout_completed_at']);
        });

        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn('requires_balance');
        });
    }
};
