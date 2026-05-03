<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'images',
            'productvars',
            'stocks',
            'productcoms',
            'pasts',
            'askques',
            'compares',
            'favories',
            'orderitems',
            'basketitems',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('product_id')->nullable()->after('product_token');
            });
        }

        foreach ($tables as $table) {
            DB::statement("
                UPDATE {$table}
                SET product_id = (
                    SELECT id
                    FROM products
                    WHERE products.product_token = {$table}.product_token
                    LIMIT 1
                )
                WHERE product_id IS NULL
            ");
        }

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'images',
            'productvars',
            'stocks',
            'productcoms',
            'pasts',
            'askques',
            'compares',
            'favories',
            'orderitems',
            'basketitems',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            });
        }
    }
};
