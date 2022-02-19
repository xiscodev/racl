<?php

namespace Xiscodev\Racl;

use Illuminate\Support\ServiceProvider;
use Xiscodev\Racl\Responser\RaclResponser;
use Xiscodev\Racl\Requester\RaclRequester;

class RaclServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RaclResponser::class, function () {
            return new RaclResponser();
        });

        $this->app->singleton(RaclRequester::class, function () {
            return new RaclRequester();
        });
    }
}
