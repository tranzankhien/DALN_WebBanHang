<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Alias the namespaced AdvertController to the global name in case some
        // routes or cached references use the non-namespaced class name
        // "AdvertController". This avoids the BindingResolutionException while
        // we trace and fix the stale reference.
        if (class_exists(\App\Http\Controllers\AdvertController::class)) {
            \class_alias(\App\Http\Controllers\AdvertController::class, 'AdvertController');
        }
    }
}
