<?php

namespace App\Contracts\Presenters;

interface MediaPresenterContract extends PresenterContract
{
    public function getId(): int;

    public function getSource(): string;

    public function getThumbSource(): string;
}
