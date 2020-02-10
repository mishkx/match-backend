<?php

namespace App\Listeners;

use App\Events\ChatMessageCreated;
use App\Models\Chat\Message;
use ChatService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFakeMessage implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ChatMessageCreated $event)
    {
        if ($event->getIsFake()) {
            return;
        }

        $message = factory(Message::class)->make();

        ChatService::createFakeMessage(
            $event->getToUserId(),
            $event->getThread()->participant->user_id,
            $message->content,
            $message->token,
            now()->toDateTimeString()
        );

    }
}
