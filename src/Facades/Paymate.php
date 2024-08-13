<?php

namespace Homeful\Paymate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Homeful\Paymate\Paymate
 */
class Paymate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Homeful\Paymate\Paymate::class;
    }
}
