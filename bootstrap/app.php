<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Registering your custom route middleware aliases
        // These aliases are used in your routes files like routes/web.php
        $middleware->alias([
            'Admin'        => \App\Http\Middleware\Admin::class,
            'AdminGuest'   => \App\Http\Middleware\AdminGuest::class,
            'PatientGuest' => \App\Http\Middleware\PatientGuest::class,
            'Patient'      => \App\Http\Middleware\Patient::class,
            'Install'      => \App\Http\Middleware\Install::class,
            'Locale'       => \App\Http\Middleware\Locale::class,
            'auth'         => \App\Http\Middleware\Authenticate::class,
            'guest'        => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);

        // Global middleware configuration can also be added here if needed
        $middleware->validateCsrfTokens(except: [
            // Add any URIs that should be excluded from CSRF verification
            // example: 'api/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle custom exception reporting or rendering here
    })->create();