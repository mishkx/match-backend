<?php

namespace App\Presenters;

use App\Base\Presenter;
use App\Contracts\Presenters\ChatThreadPresenterContract;

class ChatThreadPresenter extends Presenter implements ChatThreadPresenterContract
{
    public function getUnreadCount(): int
    {
        return self::integer($this->getResourceValue('messages_count'));
    }

    public function getUpdatedAt(): string
    {
        return self::dateTime($this->getResourceValue('refreshed_at'));
    }
}
