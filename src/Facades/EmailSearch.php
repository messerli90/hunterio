<?php

namespace Messerli90\Hunterio\Facades;

use Illuminate\Support\Facades\Facade;

class EmailSearch extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hunter-email-search';
    }
}
