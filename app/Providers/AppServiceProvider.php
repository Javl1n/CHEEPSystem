<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\Feature;

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
        Blade::if('role', function (string $value) {
            return strtolower(auth()->user()->role->name) === strtolower($value);
        });

        Blade::if('feature', function (string $feature) {
            return Feature::where('title', $feature)->first()->enabled;
        });
    }
}
