<?php

namespace App\Presenters;

use App\Base\Presenter;
use App\Contracts\Presenters\UserMatchPresenterContract;

class UserMatchPresenter extends Presenter implements UserMatchPresenterContract
{
    public function getIsLiked(): bool
    {
        return self::boolean($this->getResourceValue('is_liked'));
    }

    public function getIsVisited(): bool
    {
        return self::boolean($this->getResourceValue('is_visited'));
    }

    public function getChosenAt(): ?string
    {
        return self::nullableDateTime($this->getResourceValue('chosen_at'));
    }
}
