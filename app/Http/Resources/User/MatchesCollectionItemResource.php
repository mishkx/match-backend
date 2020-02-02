<?php

namespace App\Http\Resources\User;

use App\Http\Resources\MediaResource;
use App\Presenters\UserPresenter;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="MatchesCollectionItemResource",
 *     type="object"
 * )
 */
class MatchesCollectionItemResource extends JsonResource
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
             *     property="isVisited",
             *     type="boolean",
             * )
             */
            'isVisited' => $presenter->getObjectMatch()->getIsVisited(),

            /**
             * @OA\Property(
             *     property="photo",
             *     allOf={@OA\Schema(ref="#/components/schemas/MediaResource")},
             * )
             */
            'photo' => new MediaResource($presenter->getMainPhoto()),
        ];
    }
}
