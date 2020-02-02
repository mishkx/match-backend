<?php

namespace App\Presenters;

use App\Base\Presenter;
use App\Constants\UserConstants;
use App\Contracts\Presenters\MediaPresenterContract;
use Spatie\MediaLibrary\Models\Media;

class MediaPresenter extends Presenter implements MediaPresenterContract
{
    /**
     * @var Media
     */
    protected $resource;

    public function getId(): int
    {
        return $this->resource->getKey();
    }

    public function getSource(): string
    {
        return $this->resource->getFullUrl();
    }

    public function getThumbSource(): string
    {
        return $this->resource->getFullUrl(UserConstants::MEDIA_CONVERSION_AVATAR);
    }
}
