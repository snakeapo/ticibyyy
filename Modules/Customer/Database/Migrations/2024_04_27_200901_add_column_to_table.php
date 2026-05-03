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
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname');
            $table->string('avatar');
            $table->string('referance')->nullable();
            $table->string('identy');
            $table->string('balance');
            $table->enum('role',['admin','user'])->default('user');
            $table->string('user_phone')->nullable();
            $table->enum('sex',['male','female']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
