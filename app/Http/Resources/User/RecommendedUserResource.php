<?php

namespace App\Http\Resources\User;

use App\Http\Resources\MediaResource;
use App\Presenters\UserPresenter;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RecommendedUserResource",
 *     type="object"
 * )
 */
class RecommendedUserResource extends JsonResource
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
             *     property="gender",
             *     type="string",
             *     enum={USER_GENDER_MALE, USER_GENDER_FEMALE}
             * )
             */
            'gender' => $presenter->getGender(),

            /**
             * @OA\Property(
             *     property="distance",
             *     type="integer",
             * )
             */
            'distance' => $presenter->getState()->getDistance(),

            /**
             * @OA\Property(
             *     property="age",
             *     type="integer",
             * )
             */
            'age' => $presenter->getAge(),

            /**
             * @OA\Property(
             *     property="description",
             *     type="string",
             * )
             */
            'description' => $presenter->getDescription(),

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
