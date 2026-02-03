<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set default string length for database migrations
        Schema::defaultStringLength(191);

        // Register Passport commands for terminal use
        $this->commands([
            InstallCommand::class,
            ClientCommand::class,
            KeysCommand::class,
        ]);

        /**
         * Register Dynamic Permissions from Database
         * This allows @can('permission_key') to work in Blade
         */
        try {
            // Fetch all 76 permissions from your database
            Permission::all()->each(function ($permission) {
                Gate::define($permission->key, function (User $user) use ($permission) {
                    return $user->hasPermission($permission->key);
                });
            });
        } catch (\Exception $e) {
            // Prevent error if database tables are not yet migrated
        }

        /**
         * Define a custom 'admin' gate for the dashboard
         * Matches your super_admin role (ID 1)
         */
        Gate::define('admin', function (User $user) {
            return $user->roles->contains('name', 'super_admin');
        });
    }
}