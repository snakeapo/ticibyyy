<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auction_items', function (Blueprint $table) {
            $table->json('custom_images')->nullable()->after('custom_image');
            $table->json('custom_videos')->nullable()->after('custom_images');
        });
    }

    public function down(): void
    {
        Schema::table('auction_items', function (Blueprint $table) {
            $table->dropColumn(['custom_images', 'custom_videos']);
        });
    }
};
