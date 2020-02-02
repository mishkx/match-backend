<?php

namespace App\Facades\Services;

use App\Contracts\Services\AppServiceContract;
use Illuminate\Support\Facades\Facade;

class AppServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AppServiceContract::class;
    }
}
