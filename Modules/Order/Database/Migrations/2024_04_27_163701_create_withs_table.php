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
        Schema::create('withs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name_surname');
            $table->string('account');
            $table->string('iban');
            $table->string('bank_name');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('total');
            $table->enum('status',['1','2','0']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withs');
    }
};
