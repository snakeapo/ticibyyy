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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('order_no');
            $table->longText('order_note');
            $table->string('user_address');
            $table->string('total');
            $table->string('cargo');
            $table->enum('payment_status',['1','2','0']);
            $table->enum('payment_system',['1','2','3']);
            $table->string('comment')->nullable();
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
