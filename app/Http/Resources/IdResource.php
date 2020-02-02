<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="IdResource",
 *     type="object"
 * )
 */
class IdResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            /**
             * @OA\Property(
             *     property="id",
             *     type="integer",
             * )
             */
            'id' => $this->resource->id,
        ];
    }
}
