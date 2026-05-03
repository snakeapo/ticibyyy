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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('blog_title');
            $table->string('blog_slug');
            $table->longText('blog_desc');
            $table->foreignId('category_id')->references('id')->on('blogcats')->onDelete('cascade');
            $table->string('image');
            $table->string('blog_tag');
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
        Schema::dropIfExists('blogs');
    }
};
