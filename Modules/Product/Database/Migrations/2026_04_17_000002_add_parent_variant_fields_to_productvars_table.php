<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productvars', function (Blueprint $table) {
            $table->string('parent_variant_type')->nullable()->after('variant_type');
            $table->string('parent_variant_name')->nullable()->after('parent_variant_type');
        });
    }

    public function down(): void
    {
        Schema::table('productvars', function (Blueprint $table) {
            $table->dropColumn(['parent_variant_type', 'parent_variant_name']);
        });
    }
};
