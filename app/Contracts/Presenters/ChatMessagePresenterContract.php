<?php

namespace App\Contracts\Presenters;

interface ChatMessagePresenterContract extends PresenterContract
{
    public function getId(): int;

    public function getContent(): ?string;

    public function getToken(): string;

    public function getUserId(): int;

    public function getCreatedAt(): string;

    public function getEditedAt(): ?string;

    public function getIsDeleted(): bool;
}
