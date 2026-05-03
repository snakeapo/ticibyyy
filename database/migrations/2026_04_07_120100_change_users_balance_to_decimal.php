<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE users MODIFY balance DECIMAL(12,2) NOT NULL DEFAULT 0.00');
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('balance')->change();
        });
    }
};
