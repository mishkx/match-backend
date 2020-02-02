<?php

namespace App\Http\Resources\Chat;

use App\Models\Chat\Thread;
use App\Presenters\ChatThreadPresenter;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ChatThreadResource",
 *     type="object"
 * )
 */
class ChatThreadResource extends JsonResource
{
    /**
     * @var Thread
     */
    public $resource;

    public function toArray($request)
    {
        $presenter = new ChatThreadPresenter($this->resource);
        $messages = $this->resource->relationLoaded('latestMessage')
            ? ($this->resource->latestMessage ? [$this->resource->latestMessage] : [])
            : $this->resource->messages;

        return [
            /**
             * @OA\Property(
             *     property="unreadCount",
             *     type="integer",
             * )
             */
            'unreadCount' => $presenter->getUnreadCount(),

            /**
             * @OA\Property(
             *     property="updatedAt",
             *     type="string",
             *     format=DATETIME_FORMAT,
             * )
             */
            'updatedAt' => $presenter->getUpdatedAt(),

            /**
             * @OA\Property(
             *     property="user",
             *     allOf={@OA\Schema(ref="#/components/schemas/ChatThreadUserResource")},
             * )
             */
            'user' => new ChatThreadUserResource($this->resource->participant->user),

            /**
             * @OA\Property(
             *     property="messages",
             *     type="array",
             *     @OA\Items(ref="#/components/schemas/ChatMessageResource")
             * )
             */
            'messages' => ChatMessageResource::collection($messages),
        ];
    }
}
