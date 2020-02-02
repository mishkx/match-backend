<?php

namespace App\Contracts\Presenters;

interface UserPreferencePresenterContract extends PresenterContract
{
    public function getAgeFrom(): ?int;

    public function getAgeTo(): ?int;

    public function getMaxDistance(): ?int;

    public function getGender(): ?string;
}
