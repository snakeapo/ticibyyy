<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('brand_title');
            $table->string('brand_slug')->unique();
            $table->string('meta_title');
            $table->string('meta_keyw');
            $table->longText('meta_desc');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
