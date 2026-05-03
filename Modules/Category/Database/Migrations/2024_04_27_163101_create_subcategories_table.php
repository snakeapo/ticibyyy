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
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('sub_title');
            $table->string('sub_slug');
            $table->foreignId('top_category')->references('id')->on('categories')->onDelete('cascade');
            $table->string('meta_title');
            $table->string('meta_keyw');
            $table->longText('meta_desc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
