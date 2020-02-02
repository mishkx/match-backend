<?php

namespace App\Services;

use App\Constants\ChatConstants;
use App\Contracts\Services\AppServiceContract;
use App\Constants\UserConstants;

class AppService implements AppServiceContract
{
    public function config()
    {
        return [
            'chatMaxMessageContentLength' => ChatConstants::MAX_MESSAGE_CONTENT_LENGTH,
            'userGenderMale' => UserConstants::GENDER_MALE,
            'userGenderFemale' => UserConstants::GENDER_FEMALE,
            'userMinAge' => UserConstants::MIN_AGE,
            'userMaxAge' => UserConstants::MAX_AGE,
            'userMinDistance' => UserConstants::MIN_DISTANCE,
            'userMaxDistance' => UserConstants::MAX_DISTANCE,
            'userMaxDescriptionLength' => UserConstants::MAX_DESCRIPTION_LENGTH,
            'userMaxNameLength' => UserConstants::MAX_NAME_LENGTH,
            'userMaxPhotos' => UserConstants::MEDIA_COLLECTION_PHOTOS_ITEMS,
        ];
    }
}
