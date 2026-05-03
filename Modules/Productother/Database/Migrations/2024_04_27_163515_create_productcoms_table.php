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
        Schema::create('productcoms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('product_token');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->longText('comment');
            $table->string('point');
            $table->longText('answer')->nullable();
            $table->string('answer_time')->nullable();
            $table->string('image')->nullable();
            $table->enum('status',['1','2','0']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productcoms');
    }
};
