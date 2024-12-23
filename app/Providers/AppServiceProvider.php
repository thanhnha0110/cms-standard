<?php

namespace App\Providers;

use App\Helpers\FileHelper;
use App\Helpers\SettingHelper;
use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\PostObserver;
use App\Observers\SettingObserver;
use App\Observers\TagObserver;
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
        Setting::observe(SettingObserver::class);
        Tag::observe(TagObserver::class);
        Category::observe(CategoryObserver::class);
        Post::observe(PostObserver::class);
    }
}