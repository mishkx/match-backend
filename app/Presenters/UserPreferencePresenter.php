<?php

namespace App\Presenters;

use App\Base\Presenter;
use App\Contracts\Presenters\UserPreferencePresenterContract;

class UserPreferencePresenter extends Presenter implements UserPreferencePresenterContract
{
    public function getAgeFrom(): ?int
    {
        return self::nullableInteger($this->getResourceValue('age_from'));
    }

    public function getAgeTo(): ?int
    {
        return self::nullableInteger($this->getResourceValue('age_to'));
    }

    public function getMaxDistance(): ?int
    {
        return self::nullableInteger($this->getResourceValue('max_distance'));
    }

    public function getGender(): ?string
    {
        return self::nullableString($this->getResourceValue('gender'));
    }
}
