<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register the routes for Pusher/Broadcasting
        // This handles authentication for private channels
        Broadcast::routes();

        // Load the channel authorization rules
        //
        require base_path('routes/channels.php');
    }
}