<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot()
    {
        $this->registerPolicies();

        if (DB::connection()->getDatabaseName() && Schema::hasTable('permissions')) {
            
            // ১. সুপার এডমিনকে (ID 1) শুরুতেই সব পারমিশন দেওয়া
            Gate::before(function ($user, $ability) {
                if ($user->id === 1) {
                    return true;
                }
            });

            $permissions = Permission::all();

            foreach ($permissions as $permission) {
                // ২. ডাইনামিক পারমিশন গেট ডিফাইন করা
                Gate::define($permission->key, function ($user) use ($permission) {
                    return $user->hasPermission($permission->key);
                });
            }

            // ৩. এডমিন ড্যাশবোর্ড এক্সেস গেট
            Gate::define('admin', function ($user) {
                // super_admin রোল চেক করা
                return $user->roles->contains('name', 'super_admin');
            });

            Gate::define('patient', function ($user) {
                return auth()->guard('patient')->check();
            });
        }
    }
}