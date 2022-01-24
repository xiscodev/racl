<?php

namespace Xiscodev\Racl;

use Illuminate\Support\ServiceProvider;

class RaclServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind('racl', function () {
            return new Racl();
        });
    }
}
