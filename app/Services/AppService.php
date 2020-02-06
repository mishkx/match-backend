<?php

namespace App\Services;

use App\Constants\ChatConstants;
use App\Contracts\Services\AppServiceContract;
use App\Constants\UserConstants;

class AppService implements AppServiceContract
{
    protected function getBroadcastingConfig()
    {
        $driver = config('broadcasting.default');
        $broadcaster = $driver;

        switch ($driver) {
            case 'pusher':
                $options = [
                    'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                    'forceTLS' => config('broadcasting.connections.pusher.options.useTLS'),
                    'key' => config('broadcasting.connections.pusher.key'),
                ];
                break;

            case 'redis':
            default:
                $broadcaster = 'socket.io';
                $options = [
                    'host' => config('app.url'),
                ];
        }

        return [
            'broadcaster' => $broadcaster,
            'options' => $options,
        ];
    }

    public function config()
    {
        return [
            'chatMaxMessageContentLength' => ChatConstants::MAX_MESSAGE_CONTENT_LENGTH,
            'socket' => $this->getBroadcastingConfig(),
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
