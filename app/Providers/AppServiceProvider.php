<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Settings;
use App\Models\AuthInfoCard;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('settings')) {
            $setting = Settings::find(1);
            view()->share('setting', $setting);
        }

        if (Schema::hasTable('auth_info_cards')) {
            $authInfoCards = AuthInfoCard::query()->orderBy('id')->get();
            view()->share('authInfoCards', $authInfoCards);
        }
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
    }
}
