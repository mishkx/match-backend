<?php

namespace App\Facades\Services;

use App\Contracts\Services\UserServiceContract;
use Illuminate\Support\Facades\Facade;

class UserServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UserServiceContract::class;
    }
}
