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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('meta_title');
            $table->string('meta_desc');
            $table->string('meta_keyw');
            $table->string('mail_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('address')->nullable();
            $table->string('footer')->nullable();
            $table->string('footer_desc')->nullable();
            $table->string('logo');
            $table->string('light_logo');
            $table->string('favicon');
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('pinterest')->nullable();
            $table->longText('live_support')->nullable();
            $table->longText('google_analystics')->nullable();
            $table->string('google_play')->nullable();
            $table->string('app_store')->nullable();
            $table->longText('google_maps')->nullable();
            $table->string('google_place_id')->nullable();
            $table->string('google_api_key')->nullable();
            $table->enum('google_comment',['1','0'])->nullable();
            $table->string('referance_earning')->nullable();
            $table->string('min_widthdraw')->nullable();
            $table->string('free_cargo')->nullable();
            $table->string('paytr_id')->nullable();
            $table->string('paytr_salt')->nullable();
            $table->string('paytr_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
