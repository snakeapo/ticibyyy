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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('has_return')->default(false)->after('best_selling');
            $table->boolean('has_exchange')->default(false)->after('has_return');
            $table->boolean('whatsapp_order_enabled')->default(false)->after('has_exchange');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'has_return',
                'has_exchange',
                'whatsapp_order_enabled',
            ]);
        });
    }
};
