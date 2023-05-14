<?php

namespace Ikay\TheharvesterService\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ikay\TheharvesterService\TheharvesterService
 */
class TheharvesterService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Ikay\TheharvesterService\TheharvesterService::class;
    }
}
