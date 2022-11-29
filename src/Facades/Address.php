<?php

namespace Corals\Modules\Utility\Location\Facades;

use Illuminate\Support\Facades\Facade;

class Address extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Utility\Location\Classes\Address::class;
    }
}
