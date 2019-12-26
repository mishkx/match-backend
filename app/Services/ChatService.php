<?php

namespace App\Services;

use AccountService;
use App\Contracts\Services\ChatContract;
use App\Models\Account\User;
use App\Models\Chat\Message;
use App\Models\Chat\Thread;
use Illuminate\Database\Eloquent\Builder;

class ChatService implements ChatContract
{
    public function getAvailableThreadsQuery(User $user)
    {
        return Thread::whereAvailableForUser($user->id)
            ->orderByDesc('refreshed_at');
    }

    public function getAvailableThreadsWithLatestMessageQuery(User $user)
    {
        return $this->getAvailableThreadsQuery($user)
            ->withLatestMessage();
    }

    public function getThreadMessagesQuery(User $user, $threadId)
    {
        return Message::whereHas('thread', function ($query) use ($user, $threadId) {
            /** @var Thread $query */
            $query->whereAvailableForUser($user->id)
                ->where('id', $threadId);
        })->latest();
    }

    public function paginateLatestItems($query, $fromItemId, $limit)
    {
        return $query
            ->where(function ($query) use ($fromItemId) {
                /** @var Builder $query */
                if ($fromItemId > 0) {
                    $query->where('id', '<', $fromItemId);
                }
            })
            ->limit($limit)
            ->get();
    }

    public function paginateThreads($fromItemId)
    {
        return $this->paginateLatestItems(
            $this->getAvailableThreadsWithLatestMessageQuery(AccountService::user()),
            $fromItemId,
            config('options.chat.threads.limit')
        );
    }

    public function paginateMessages($fromItemId, $threadId)
    {
        return $this->paginateLatestItems(
            $this->getThreadMessagesQuery(AccountService::user(), $threadId),
            $fromItemId,
            config('options.chat.messages.limit')
        );
    }
}
