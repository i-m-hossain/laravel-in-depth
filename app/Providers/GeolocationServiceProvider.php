<?php

namespace App\Providers;

use App\Services\Geolocation\Geolocation;
use App\Services\Geolocation\Map\Map;
use App\Services\Geolocation\Satellite\Satellite;
use Illuminate\Support\ServiceProvider;

class GeolocationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    $this->app->bind(Geolocation::class, function($app){
        $map = new Map();
        $satellite = new Satellite();
        return new Geolocation($map, $satellite);
        // return 'hello';
    });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
