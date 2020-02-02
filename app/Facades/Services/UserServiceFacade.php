<?php

namespace App\Facades\Services;

use App\Contracts\Services\AccountContract;
use Illuminate\Support\Facades\Facade;

class AccountFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AccountContract::class;
    }
}
