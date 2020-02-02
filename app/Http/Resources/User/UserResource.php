<?php

namespace App\Http\Resources\User;

use App\Http\Resources\MediaResource;
use App\Presenters\UserPresenter;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UserResource",
 *     type="object"
 * )
 */
class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $presenter = new UserPresenter($this->resource);

        return [
            /**
             * @OA\Property(
             *     property="id",
             *     type="integer",
             * )
             */
            'id' => $presenter->getId(),

            /**
             * @OA\Property(
             *     property="name",
             *     type="string",
             * )
             */
            'name' => $presenter->getName(),

            /**
             * @OA\Property(
             *     property="email",
             *     type="string",
             * )
             */
            'email' => $presenter->getEmail(),

            /**
             * @OA\Property(
             *     property="gender",
             *     type="string",
             *     enum={USER_GENDER_MALE, USER_GENDER_FEMALE},
             *     nullable=true,
             * )
             */
            'gender' => $presenter->getGender(),

            /**
             * @OA\Property(
             *     property="bornOn",
             *     type="string",
             *     format=DATE_FORMAT,
             *     nullable=true,
             * )
             */
            'bornOn' => $presenter->getBornOn(),

            /**
             * @OA\Property(
             *     property="age",
             *     type="integer",
             *     nullable=true,
             * )
             */
            'age' => $presenter->getAge(),

            /**
             * @OA\Property(
             *     property="description",
             *     type="string",
             *     nullable=true,
             * )
             */
            'description' => $presenter->getDescription(),

            /**
             * @OA\Property(
             *     property="dataIsFilled",
             *     type="boolean",
             * )
             */
            'dataIsFilled' => $presenter->getDataIsFilled(),

            /**
             * @OA\Property(
             *     property="preferences",
             *     allOf={@OA\Schema(ref="#/components/schemas/UserPreferencesResource")},
             * )
             */
            'preferences' => new UserPreferencesResource($this->resource),

            /**
             * @OA\Property(
             *     property="photos",
             *     type="array",
             *     @OA\Items(ref="#/components/schemas/MediaResource")
             * )
             */
            'photos' => MediaResource::collection($this->resource->media),
        ];
    }
}
