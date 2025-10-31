<?php

namespace App\Providers;

use App\Models\Property;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        Route::bind('land_jamin', function ($value) {
            return Property::find($value);
        });
        Route::bind('shop', function ($value) {
            return Property::find($value);
        });
        Route::bind('shad', function ($value) {
            return Property::find($value);
        });
        Route::bind('house', function ($value) {
            return Property::find($value);
        });
        Route::bind('plot', function ($value) {
            return Property::find($value);
        });
    }
}