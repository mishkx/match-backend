<?php

namespace App\Contracts\Presenters;

interface UserStatePresenterContract extends PresenterContract
{
    public function getDistance(): ?int;
}
