<?php

namespace App\Contracts\Presenters;

interface UserMatchPresenterContract extends PresenterContract
{
    public function getIsLiked(): bool;

    public function getIsVisited(): bool;

    public function getChosenAt(): ?string;
}
