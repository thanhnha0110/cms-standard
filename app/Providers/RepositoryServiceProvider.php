<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Repositories\Eloquent\EloquentLogRepository;
use App\Repositories\Eloquent\EloquentPermissionRepository;
use App\Repositories\Eloquent\EloquentRoleRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerBindings()
    {
        $this->app->bind('App\Repositories\UserRepository', function () {
            return new EloquentUserRepository(new User());
        });

        $this->app->bind('App\Repositories\RoleRepository', function () {
            return new EloquentRoleRepository(new Role());
        });

        $this->app->bind('App\Repositories\PermissionRepository', function () {
            return new EloquentPermissionRepository(new Permission());
        });

        $this->app->bind('App\Repositories\LogRepository', function () {
            return new EloquentLogRepository(new ActivityLog());
        });
    }
}