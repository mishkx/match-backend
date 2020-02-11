<?php

namespace App\Listeners;

use App\Events\ChatMessageCreated;
use App\Models\Chat\Message;
use ChatService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use UserService;

class SendFakeMessage implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ChatMessageCreated $event)
    {
        if (
            !config('options.faker')
            || $event->getIsFake()
            || UserService::wasActiveRecently($event->getToUserId())
        ) {
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
