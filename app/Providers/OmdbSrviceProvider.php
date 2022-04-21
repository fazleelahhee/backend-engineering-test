<?php

namespace App\Providers;

use App\Services\Movies\Contracts\MovieContract;
use App\Services\Movies\OmdbClient;
use Illuminate\Support\ServiceProvider;

class OmdbSrviceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MovieContract::class, function ($app) {
            return new OmdbClient(
                config('services.omdb.uri'),
                config('services.omdb.key')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
