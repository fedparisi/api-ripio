<?php

namespace App\Service\Exchange\Ripio;

use Illuminate\Support\Facades\Facade;

class RipioFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Ripio::class;
    }
}
