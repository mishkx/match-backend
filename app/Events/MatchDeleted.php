<?php

namespace App\Events;

use App\Http\Resources\IdResource;
use App\Models\Account\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    protected int $toUserId;
    protected User $fromUser;

    public function __construct($toUserId, User $fromUser)
    {
        $this->toUserId = $toUserId;
        $this->fromUser = $fromUser;
    }

    public function broadcastAs()
    {
        return 'match.deleted';
    }

    public function broadcastOn()
    {
        return new PrivateChannel("user.{$this->toUserId}");
    }

    public function broadcastWith()
    {
        return collect(new IdResource($this->fromUser))->toArray();
    }
}
