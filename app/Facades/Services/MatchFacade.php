<?php

namespace App\Facades\Services;

use App\Contracts\Services\MatchContract;
use Illuminate\Support\Facades\Facade;

class MatchFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MatchContract::class;
    }
}
