<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auction_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auction_id');
            $table->unsignedBigInteger('auction_item_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('order_no')->unique();
            $table->decimal('final_price', 12, 2);
            $table->text('address_snapshot');
            $table->enum('win_type', ['bid', 'buy_now', 'auto_buy_now']);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_orders');
    }
};
