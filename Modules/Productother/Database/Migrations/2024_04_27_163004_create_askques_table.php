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
        Schema::create('askques', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText('ask');
            $table->longText('answer')->nullable();
            $table->string('answer_time')->nullable();
            $table->string('product_token');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('askques');
    }
};
