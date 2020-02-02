<?php

namespace App\Events;

use App\Http\Resources\Chat\ChatThreadResource;
use App\Models\Chat\Thread;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    protected int $toUserId;
    protected $thread;

    public function __construct($toUserId, Thread $thread)
    {
        $this->toUserId = $toUserId;
        $this->thread = $thread;
    }

    public function broadcastAs()
    {
        return 'chat.message.created';
    }

    public function broadcastOn()
    {
        return new PrivateChannel("user.{$this->toUserId}");
    }

    public function broadcastWith()
    {
        return collect(new ChatThreadResource($this->thread))->toArray();
    }
}
