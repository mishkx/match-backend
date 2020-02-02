<?php

namespace App\Facades\Services;

use App\Contracts\Services\RecommendationContract;
use Illuminate\Support\Facades\Facade;

class RecommendationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RecommendationContract::class;
    }
}
