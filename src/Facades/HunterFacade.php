<?php

namespace Messerli90\Hunterio\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Messerli90\Hunterio\Skeleton\SkeletonClass
 */
class HunterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hunter';
    }
}
