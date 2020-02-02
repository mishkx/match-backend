<?php

namespace App\Facades\Services;

use App\Contracts\Services\ChoiceContract;
use Illuminate\Support\Facades\Facade;

class ChoiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ChoiceContract::class;
    }
}
