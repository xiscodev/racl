<?php

namespace Xiscodev\Racl;

use Illuminate\Support\ServiceProvider;
use Xiscodev\Racl\Responser\RaclResponser;
use Xiscodev\Racl\Requester\RaclRequester;

class RaclServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RaclResponser::class, function ($app) {
            return new RaclResponser();
        });

        $this->app->singleton(RaclRequester::class, function ($app) {
            return new RaclRequester();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [RaclResponser::class, RaclRequester::class];
    }
}
