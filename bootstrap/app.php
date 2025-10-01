<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\CheckUserPermission;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\CheckPasswordExpiration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => CheckUserRole::class,
            'permission' => CheckUserPermission::class,
            'guest' => RedirectIfAuthenticated::class,
        ]);
        
        // Add security headers middleware globally
        $middleware->append(SecurityHeaders::class);
        
        // Check password expiration
        $middleware->append(CheckPasswordExpiration::class);
        
        // Note: ForceHttps middleware has been temporarily disabled due to SSL configuration issues
        // $middleware->append(ForceHttps::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();