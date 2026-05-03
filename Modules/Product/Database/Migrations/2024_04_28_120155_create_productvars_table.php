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
        Schema::create('productvars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('product_token')->nullable();
            $table->string('variant_image')->nullable();
            $table->string('variant_name')->nullable();
            $table->string('variant_price')->nullable();
            $table->string('variant_stock')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productvars');
    }
};
