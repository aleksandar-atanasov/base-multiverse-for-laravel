<?php

namespace Aleksandar\Multiverse\Facades;

use Aleksandar\Multiverse\Contracts\ConversionPolicyInterface;
use Illuminate\Support\Facades\Facade;

class BaseConverter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ConversionPolicyInterface::class;
    }
}
