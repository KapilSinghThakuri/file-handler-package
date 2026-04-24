<?php

namespace Kapil\FileHandler;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kapil\FileHandler\Skeleton\SkeletonClass
 */
class FileHandlerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'file-handler';
    }
}
