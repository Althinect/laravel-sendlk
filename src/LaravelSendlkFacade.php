<?php

namespace Althinect\LaravelSendlk;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Althinect\LaravelSendlk\Skeleton\SkeletonClass
 */
class LaravelSendlkFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-sendlk';
    }
}
