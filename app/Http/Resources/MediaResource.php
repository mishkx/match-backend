<?php

namespace App\Http\Resources;

use App\Presenters\MediaPresenter;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="MediaResource",
 *     type="object"
 * )
 */
class MediaResource extends JsonResource
{
    public function toArray($request)
    {
        $presenter = new MediaPresenter($this->resource);

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
             *     property="src",
             *     type="string",
             * )
             */
            'src' => $presenter->getSource(),

            /**
             * @OA\Property(
             *     property="thumb",
             *     type="string",
             * )
             */
            'thumb' => $presenter->getThumbSource(),
        ];
    }
}
