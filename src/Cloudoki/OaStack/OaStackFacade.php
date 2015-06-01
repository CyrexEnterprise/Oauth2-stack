<?php namespace Cloudoki\OaStack\Facades;

use Illuminate\Support\Facades\Facade;

class OaStack extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'oastack';
    }

}