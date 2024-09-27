<?php

namespace App\Providers;

use App\Services\Nilai2Service;
use Illuminate\Support\ServiceProvider;

class Nilai2ServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(Nilai2Service::class, function ($app) {
            return new Nilai2Service();
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
