<?php

namespace Xiscodev\Racl;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Xiscodev\Racl\Racl
 */
class RaclFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'racl';
    }
}
