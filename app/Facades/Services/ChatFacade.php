<?php

namespace App\Facades\Services;

use App\Contracts\Services\ChatContract;
use Illuminate\Support\Facades\Facade;

class ChatFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ChatContract::class;
    }
}
