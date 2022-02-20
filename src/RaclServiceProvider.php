<?php

namespace Xiscodev\Racl;

use Illuminate\Support\ServiceProvider;
use Xiscodev\Racl\Responser\RaclResponser;
use Xiscodev\Racl\Requester\RaclRequester;

class RaclServiceProvider extends ServiceProvider
{
    /**
     * The classes to be registered.
     *
     * @var array
     */
    protected $classes = [
        'RaclResponser' => RaclResponser::class,
        'RaclRequester' => RaclRequester::class,
    ];

    /**
     * Register the given classes.
     *
     * @param array $classes
     */
    protected function registerClasses(array $classes)
    {
        foreach (array_keys($classes) as $class) {
            $method = "register{$class}Class";

            call_user_func_array([$this, $method], []);
        }

        // $this->classes(array_values($classes));
    }


    protected function registerRaclResponserClass()
    {
        $this->app->singleton($this->classes['RaclResponser'], function () {
            return new RaclResponser();
        });
    }

    protected function registerRaclRequesterClass()
    {
        $this->app->singleton($this->classes['RaclRequester'], function () {
            return new RaclRequester();
        });
    }


    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerClasses($this->classes);
    }
}
