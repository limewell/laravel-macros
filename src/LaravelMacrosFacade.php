<?php

namespace Limewell\LaravelMacros;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Limewell\LaravelMacros\Skeleton\SkeletonClass
 */
class LaravelMacrosFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-macros';
    }
}
