<?php

namespace App\Constants;

use Spatie\Image\Manipulations;

class UserConstants
{
    public const MIN_AGE = 18;
    public const MAX_AGE = 100;

    public const GENDER_MALE = 'm';
    public const GENDER_FEMALE = 'f';

    public const DISTANCE_MULTIPLIER = 1000;

    public const MIN_PASSWORD_LENGTH = 8;

    public const MIN_DISTANCE = 5;
    public const MAX_DISTANCE = 250;

    public const MAX_DESCRIPTION_LENGTH = 140;

    public const MAX_NAME_LENGTH = 20;

    public const MEDIA_COLLECTION_PHOTOS = 'photos';
    public const MEDIA_COLLECTION_PHOTOS_FORMAT = Manipulations::FORMAT_JPG;
    public const MEDIA_COLLECTION_PHOTOS_WIDTH = 1080;
    public const MEDIA_COLLECTION_PHOTOS_ITEMS = 9;
    public const MEDIA_COLLECTION_PHOTOS_MIN_WIDTH = 300;
    public const MEDIA_CONVERSION_AVATAR = 'thumb';
    public const MEDIA_CONVERSION_AVATAR_WIDTH = 96;
}
