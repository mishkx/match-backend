<?php

namespace App\Http\Resources\User;

use App\Presenters\UserPresenter;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UserPreferencesResource",
 *     type="object"
 * )
 */
class UserPreferencesResource extends JsonResource
{
    public function toArray($request)
    {
        $presenter = new UserPresenter($this->resource);

        return [
            /**
             * @OA\Property(
             *     property="ageFrom",
             *     type="integer",
             *     nullable=true,
             * )
             */
            'ageFrom' => $presenter->getPreference()->getAgeFrom(),

            /**
             * @OA\Property(
             *     property="ageTo",
             *     type="integer",
             *     nullable=true,
             * )
             */
            'ageTo' => $presenter->getPreference()->getAgeTo(),

            /**
             * @OA\Property(
             *     property="maxDistance",
             *     type="integer",
             *     nullable=true,
             * )
             */
            'maxDistance' => $presenter->getPreference()->getMaxDistance(),

            /**
             * @OA\Property(
             *     property="gender",
             *     type="string",
             *     nullable=true,
             *     enum={USER_GENDER_MALE, USER_GENDER_FEMALE}
             * )
             */
            'gender' => $presenter->getPreference()->getGender(),
        ];
    }
}
