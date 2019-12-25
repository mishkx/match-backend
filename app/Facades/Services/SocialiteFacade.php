<?php

namespace App\Facades\Services;

use App\Contracts\Services\SocialiteContract;
use Illuminate\Support\Facades\Facade;

class SocialiteFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SocialiteContract::class;
    }
}
