<?php

namespace App\Presenters;

use App\Base\Presenter;
use App\Constants\UserConstants;
use App\Contracts\Presenters\UserStatePresenterContract;
use Illuminate\Support\Arr;

class UserStatePresenter extends Presenter implements UserStatePresenterContract
{
    public function getDistance(): ?int
    {
        if (!Arr::has($this->resource, 'distance')) {
            return null;
        }
        return self::integer(round(self::integer($this->getResourceValue('distance')) / UserConstants::DISTANCE_MULTIPLIER));
    }
}
