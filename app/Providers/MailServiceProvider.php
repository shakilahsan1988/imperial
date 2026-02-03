<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Check if settings table exists to avoid errors during migration
        if (Schema::hasTable('settings')) {
            $mail = setting('emails');

            if (!empty($mail)) {
                // Formatting configuration for Laravel 11/12
                $config = [
                    'default' => 'smtp',
                    'mailers' => [
                        'smtp' => [
                            'transport' => 'smtp',
                            'host' => $mail['host'],
                            'port' => $mail['port'],
                            'encryption' => $mail['encryption'],
                            'username' => $mail['username'],
                            'password' => $mail['password'],
                            'timeout' => null,
                            'local_domain' => env('MAIL_EHLO_DOMAIN'),
                        ],
                    ],
                    'from' => [
                        'address' => $mail['from_address'],
                        'name' => $mail['from_name'],
                    ],
                ];
                
                // Overriding the default mail configuration
                Config::set('mail', $config);
            }
        }
    }
}