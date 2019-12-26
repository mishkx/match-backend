<?php

namespace App\Contracts\Services;

use App\Models\Account\User;
use Illuminate\Database\Eloquent\Builder;

interface ChatContract
{
    public function getAvailableThreadsQuery(User $user);

    public function getAvailableThreadsWithLatestMessageQuery(User $user);

    public function getThreadMessagesQuery(User $user, $threadId);

    /**
     * @param Builder $query
     * @param int|null $fromItemId
     * @param int $limit
     * @return mixed
     */
    public function paginateLatestItems($query, $fromItemId, $limit);

    public function paginateThreads($fromItemId);

    public function paginateMessages($fromItemId, $threadId);
}
