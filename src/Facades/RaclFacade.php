<?php

namespace Xiscodev\Racl\Facades;

use Illuminate\Support\Facades\Facade;

class RaclFacade extends Facade
{
    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor()
    {
        return 'racl';
    }
}
