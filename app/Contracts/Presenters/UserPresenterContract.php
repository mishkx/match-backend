<?php

namespace App\Contracts\Presenters;

use Spatie\MediaLibrary\Models\Media;

interface UserPresenterContract extends PresenterContract
{
    public function getId(): int;

    public function getName(): string;

    public function getEmail(): string;

    public function getGender(): ?string;

    public function getAge(): ?int;

    public function getBornOn(): ?string;

    public function getDescription(): ?string;

    public function getPreference(): UserPreferencePresenterContract;

    public function getState(): UserStatePresenterContract;

    public function getObjectMatch(): UserMatchPresenterContract;

    public function getSubjectMatch(): UserMatchPresenterContract;

    public function getIsMatched(): bool;

    public function getMatchedAt(): ?string;

    public function getDataIsFilled(): bool;

    public function getMainPhoto(): ?Media;
}
