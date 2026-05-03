<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('status', ['draft', 'live', 'completed'])->default('draft');
            $table->unsignedBigInteger('current_item_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });

        Schema::create('auction_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auction_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('custom_title')->nullable();
            $table->text('custom_description')->nullable();
            $table->string('custom_image')->nullable();
            $table->decimal('buy_now_price', 12, 2);
            $table->decimal('start_price', 12, 2);
            $table->decimal('min_increment', 12, 2)->default(100);
            $table->integer('idle_timeout_seconds')->default(180);
            $table->enum('status', ['pending', 'live', 'sold', 'unsold'])->default('pending');
            $table->unsignedBigInteger('winner_user_id')->nullable();
            $table->decimal('winning_bid', 12, 2)->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('last_bid_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('auction_bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auction_item_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['active', 'outbid_refunded', 'winner'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_bids');
        Schema::dropIfExists('auction_items');
        Schema::dropIfExists('auctions');
    }
};
