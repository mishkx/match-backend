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
    protected bool $isFake;
    protected $thread;

    public function __construct($toUserId, Thread $thread, $isFake = false)
    {
        $this->toUserId = $toUserId;
        $this->thread = $thread;
        $this->isFake = $isFake;
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

    public function getToUserId()
    {
        return $this->toUserId;
    }

    public function getIsFake()
    {
        return $this->isFake;
    }

    public function getThread()
    {
        return $this->thread;
    }
}
