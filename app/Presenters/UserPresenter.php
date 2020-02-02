<?php

namespace App\Presenters;

use App\Base\Presenter;
use App\Constants\AppConstants;
use App\Constants\UserConstants;
use App\Contracts\Presenters\UserMatchPresenterContract;
use App\Contracts\Presenters\UserPreferencePresenterContract;
use App\Contracts\Presenters\UserPresenterContract;
use App\Contracts\Presenters\UserStatePresenterContract;
use App\Models\Account\User;
use Carbon\Carbon;
use Spatie\MediaLibrary\Models\Media;

class UserPresenter extends Presenter implements UserPresenterContract
{
    /**
     * @var User
     */
    protected $resource;

    public function getId(): int
    {
        return self::integer($this->getResourceValue('id'));
    }

    public function getName(): string
    {
        return self::string($this->getResourceValue('name'));
    }

    public function getEmail(): string
    {
        return self::string($this->getResourceValue('email'));
    }

    public function getGender(): ?string
    {
        return self::nullableString($this->getResourceValue('gender'));
    }

    public function getAge(): ?int
    {
        if (!$this->resource->born_on) {
            return null;
        }
        return self::integer($this->resource->born_on->diffInYears());
    }

    public function getBornOn(): ?string
    {
        return self::nullableDateTime($this->getResourceValue('born_on'), AppConstants::DATE_FORMAT);
    }

    public function getDescription(): ?string
    {
        return self::nullableString($this->getResourceValue('description'));
    }

    public function getPreference(): UserPreferencePresenterContract
    {
        return $this->getRelationPresenter('preference', UserPreferencePresenter::class);
    }

    public function getState(): UserStatePresenterContract
    {
        return $this->getRelationPresenter('state', UserStatePresenter::class);
    }

    public function getObjectMatch(): UserMatchPresenterContract
    {
        return $this->getRelationPresenter('objectMatch', UserMatchPresenter::class);
    }

    public function getSubjectMatch(): UserMatchPresenterContract
    {
        return $this->getRelationPresenter('subjectMatch', UserMatchPresenter::class);
    }

    public function getIsMatched(): bool
    {
        return $this->getObjectMatch()->getIsLiked() && $this->getSubjectMatch()->getIsLiked();
    }

    public function getMatchedAt(): ?string
    {
        $subjectChooseAt = $this->getSubjectMatch()->getChosenAt();
        $objectChooseAt = $this->getObjectMatch()->getChosenAt();

        if (!$this->getIsMatched() || !$subjectChooseAt || !$objectChooseAt) {
            return null;
        }

        $subjectChooseAt = Carbon::createFromFormat(AppConstants::DATETIME_FORMAT, $subjectChooseAt);
        $objectChooseAt = Carbon::createFromFormat(AppConstants::DATETIME_FORMAT, $objectChooseAt);
        $dateTime = $objectChooseAt->gte($subjectChooseAt) ? $objectChooseAt : $subjectChooseAt;

        return self::nullableDateTime($dateTime);
    }

    public function getDataIsFilled(): bool
    {
        return $this->getGender()
            && $this->getBornOn()
            && $this->getPreference()->getAgeFrom()
            && $this->getPreference()->getAgeTo()
            && $this->getPreference()->getMaxDistance()
            && $this->getPreference()->getGender();
    }

    public function getMainPhoto(): ?Media
    {
        return $this->resource->getFirstMedia(UserConstants::MEDIA_COLLECTION_PHOTOS);
    }
}
