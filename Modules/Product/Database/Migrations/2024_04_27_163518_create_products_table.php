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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->foreignId('category')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('sub_category')->references('id')->on('subcategories')->onDelete('cascade');
            $table->integer('price');
            $table->string('sale_price')->nullable();
            $table->string('difference')->nullable();
            $table->string('stock');
            $table->string('image');
            $table->longText('feature')->nullable();
            $table->longText('installment')->nullable();
            $table->enum('our_choice',['1','0']);
            $table->enum('best_selling',['1','0']);
            $table->string('product_token');
            $table->string('meta_title');
            $table->string('meta_keyw');
            $table->longText('meta_desc');
            $table->enum('status',['1','0']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
