<?php

namespace SingleQuote\Cacher;

use Illuminate\Support\Facades\Facade;

class CacherFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Cacher';
    }
}
