<?php

namespace Xiscodev\Racl;

use Illuminate\Support\ServiceProvider;

class RaclServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/racl.php' => config_path('racl.php'),
        ], 'config');

        $this->loadTranslationsFrom(__DIR__.'/../lang/', 'rating');

        $this->publishes([
            __DIR__.'/../lang/' => resource_path('lang/vendor/rating'),
        ]);
    }
}
