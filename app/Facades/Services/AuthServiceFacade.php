<?php

namespace App\Facades\Services;

use App\Contracts\Services\AuthServiceContract;
use Illuminate\Support\Facades\Facade;

class AuthServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AuthServiceContract::class;
    }
}
