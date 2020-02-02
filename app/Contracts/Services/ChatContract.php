<?php

namespace App\Contracts\Services;

use App\Models\Account\User;
use App\Models\Chat\Participant;
use App\Models\Chat\Thread;
use Illuminate\Database\Eloquent\Builder;

interface ChatContract
{
    public function getAvailableThreadsQuery(User $user);

    public function getAvailableThreadsWithLatestMessageQuery(User $user);

    public function paginateThreads(User $user, int $fromItemId = null);

    public function paginateMessages(User $user, int $toUserId, int $fromMessageId = null);

    public function refreshParticipant(Participant $participant);

    public function refreshThread(Thread $thread);

    public function getParticipant(int $fromUserId, int $toUserId);

    public function createMessage(int $fromUserId, int $toUserId, string $content, string $token, string $sentAt);
}
