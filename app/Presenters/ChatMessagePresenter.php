<?php

namespace App\Presenters;

use App\Base\Presenter;
use App\Contracts\Presenters\ChatMessagePresenterContract;

class ChatMessagePresenter extends Presenter implements ChatMessagePresenterContract
{
    public function getId(): int
    {
        return self::integer($this->getResourceValue('id'));
    }

    public function getContent(): ?string
    {
        return !$this->getIsDeleted()
            ? self::string($this->getResourceValue('content'))
            : null;
    }

    public function getToken(): string
    {
        return self::string($this->getResourceValue('token'));
    }

    public function getUserId(): int
    {
        return self::integer($this->getResourceValue('participant.user_id'));
    }

    public function getCreatedAt(): string
    {
        return self::dateTime($this->getResourceValue('created_at'));
    }

    public function getEditedAt(): ?string
    {
        return self::nullableDateTime($this->getResourceValue('edited_at'));
    }

    public function getIsDeleted(): bool
    {
        return self::boolean($this->getResourceValue('deleted_at'));
    }
}
