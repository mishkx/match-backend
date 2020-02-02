<?php

namespace App\Http\Resources\Chat;

use App\Presenters\ChatMessagePresenter;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ChatSentMessageResource",
 *     type="object"
 * )
 */
class ChatSentMessageResource extends JsonResource
{
    public function toArray($request)
    {
        $presenter = new ChatMessagePresenter($this->resource);

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
             *     property="userId",
             *     type="integer",
             * )
             */
            'userId' => $presenter->getUserId(),

            /**
             * @OA\Property(
             *     property="content",
             *     type="string",
             *     nullable=true,
             * )
             */
            'content' => $presenter->getContent(),

            /**
             * @OA\Property(
             *     property="token",
             *     type="string",
             * )
             */
            'token' => $presenter->getToken(),

            /**
             * @OA\Property(
             *     property="createdAt",
             *     type="string",
             *     format=DATETIME_FORMAT,
             * )
             */
            'createdAt' => $presenter->getCreatedAt(),

            /**
             * @OA\Property(
             *     property="editedAt",
             *     type="string",
             *     format=DATETIME_FORMAT,
             *     nullable=true,
             * )
             */
            'editedAt' => $presenter->getEditedAt(),

            /**
             * @OA\Property(
             *     property="isDeleted",
             *     type="boolean",
             * )
             */
            'isDeleted' => $presenter->getIsDeleted(),
        ];
    }
}
