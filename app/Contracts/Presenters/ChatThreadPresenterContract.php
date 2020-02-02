<?php

namespace App\Contracts\Presenters;

interface ChatThreadPresenterContract extends PresenterContract
{
    public function getUnreadCount(): int;

    public function getUpdatedAt(): string;
}
