<?php

namespace Yuzderece\Netgsm;

use Illuminate\Support\Facades\Facade;

class NetgsmFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "netgsm";
    }
}
