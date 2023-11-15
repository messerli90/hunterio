<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Facades;

use Illuminate\Support\Facades\Facade;

class Hunter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hunterio';
    }
}
