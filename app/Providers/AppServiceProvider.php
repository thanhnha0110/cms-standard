<?php

namespace App\Providers;

use App\Helpers\FileHelper;
use App\Helpers\SettingHelper;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('setting', function () {
            return new SettingHelper();
        });

        $this->app->singleton('file', function () {
            return new FileHelper();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        User::observe(UserObserver::class);
    }
}