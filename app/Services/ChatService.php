<?php

namespace App\Services;

use App\Constants\ModelTable;
use App\Contracts\Services\ChatContract;
use App\Events\ChatMessageCreated;
use App\Exceptions\ChatSendMessageException;
use App\Models\Account\User;
use App\Models\Chat\Message;
use App\Models\Chat\Participant;
use App\Models\Chat\Thread;
use Illuminate\Database\Eloquent\Builder;
use Lang;
use UserService;

class ChatService implements ChatContract
{
    public function getAvailableThreadsQuery(User $user)
    {
        return Thread::whereAvailableForUser($user->id);
    }

    public function getAvailableThreadsWithLatestMessageQuery(User $user)
    {
        return $this->getAvailableThreadsQuery($user)
            ->whereHas('participant', function ($query) use ($user) {
                /** @var Participant $query */
                $query->whereExistsSameThreadUserId($user->id, true);
            })
            ->withParticipant($user->id)
            ->withUnreadMessagesCount($user->id)
            ->withLatestMessage()
            ->orderByDesc('refreshed_at');
    }

    public function paginateThreads(User $user, int $fromItemId = null)
    {
        $fromDateTime = null;

        if ($fromItemId) {
            $thread = Thread::whereHas('participants', function ($query) use ($user, $fromItemId) {
                /** @var Participant $query */
                $query
                    ->whereUserId($user->id)
                    ->whereExistsSameThreadUserId($fromItemId, true);
            })->first();
            if ($thread) {
                $fromDateTime = $thread->refreshed_at;
            }
        }

        return $this->getAvailableThreadsWithLatestMessageQuery($user)
            ->where(function ($query) use ($fromItemId, $fromDateTime) {
                /** @var Builder $query */
                if ($fromItemId && $fromDateTime) {
                    $query
                        ->where('id', '!=', $fromItemId)
                        ->where('refreshed_at', '<', $fromDateTime);
                }
            })
            ->limit(config('options.chat.threads.limit'))
            ->get();
    }

    public function paginateMessages(User $fromUser, int $toUserId, int $fromMessageId = null)
    {
        $this->refreshParticipant($this->getParticipant($fromUser->id, $toUserId));

        return Thread::withParticipant($fromUser->id)
            ->whereHas('participants', function ($query) use ($fromUser, $toUserId) {
                /** @var Participant $query */
                $query
                    ->whereUserId($fromUser->id)
                    ->whereExistsSameThreadUserId($toUserId);
            })
            ->with([
                'messages' => function ($query) use ($fromMessageId) {
                    /** @var Message $query */
                    if ($fromMessageId) {
                        $query->where(ModelTable::CHAT_MESSAGES . '.id', '<', $fromMessageId);
                    }
                    $query
                        ->with('participant')
                        ->limit(config('options.chat.messages.limit'))
                        ->latest();
                }
            ])
            ->first();
    }

    public function refreshParticipant(Participant $participant)
    {
        $participant->update([
            'visited_at' => now()->toDateTimeString(),
        ]);
    }

    public function refreshThread(Thread $thread)
    {
        $thread->update([
            'refreshed_at' => now()->toDateTimeString(),
        ]);
    }

    public function getParticipant(int $fromUserId, int $toUserId)
    {
        $fromUser = UserService::query()
            ->whereHasMatches($toUserId)
            ->find($fromUserId);

        if (!$fromUser) {
            throw new ChatSendMessageException(Lang::get("You can't send a message to this user."));
        }

        $participant = Participant::whereUserId($fromUser->id)
            ->whereExistsSameThreadUserId($toUserId)
            ->first();

        if (!$participant) {
            $thread = Thread::create([
                'refreshed_at' => now()->toDateTimeString()
            ]);
            $participant = Participant::create([
                'thread_id' => $thread->id,
                'user_id' => $fromUser->id,
            ]);
            Participant::create([
                'thread_id' => $thread->id,
                'user_id' => $toUserId,
            ]);
        }

        return $participant;
    }

    public function createMessage(int $fromUserId, int $toUserId, string $content, string $token, string $sentAt)
    {
        $participant = $this->getParticipant($fromUserId, $toUserId);

        $data = [
            'participant_id' => $participant->id,
            'token' => $token,
            'sent_at' => $sentAt,
        ];

        $message = Message::where($data)->first();

        if (!$message) {
            $message = Message::create(array_merge($data, [
                'content' => $content,
            ]));
        }

        $this->refreshParticipant($participant);
        $this->refreshThread($participant->thread);

        $thread = Thread::withParticipant($toUserId)
            ->withUnreadMessagesCount($toUserId)
            ->with([
                'messages' => function ($query) use ($message) {
                    /** @var Message $query */
                    $query->where(ModelTable::CHAT_MESSAGES . '.id', $message->id)->limit(1);
                }
            ])
            ->find($participant->thread_id);

        broadcast(new ChatMessageCreated($toUserId, $thread));

        return $message;
    }
}
