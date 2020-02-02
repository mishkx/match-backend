<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ErrorResource",
 *     type="object"
 * )
 */
class ErrorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            /**
             * @OA\Property(
             *     property="message",
             *     type="string",
             * )
             */
            'message' => $this->resource->message,

            /**
             * @OA\Property(
             *     property="exception",
             *     type="string",
             *     nullable=true,
             * )
             */
            'exception' => $this->resource->exception,
        ];
    }
}
