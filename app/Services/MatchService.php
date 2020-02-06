<?php

namespace App\Services;

use App\Events\MatchDeleted;
use App\Models\Chat\Participant;
use UserService;
use App\Constants\ModelTable;
use App\Contracts\Services\MatchContract;
use App\Exceptions\MatchUserNotFoundException;
use App\Models\Account\Match;
use App\Models\Account\User;
use ChoiceService;
use Illuminate\Database\Eloquent\Builder;
use Lang;

class MatchService implements MatchContract
{
    public function getMatch(int $subjectId, int $objectId)
    {
        return Match::whereSubjectId($subjectId)
            ->whereObjectId($objectId)
            ->first();
    }

    public function getMatchedUsersQuery(User $user)
    {
        return UserService::query()
            ->whereHasMatches($user->id)
            ->withObjectMatchForSubject($user->id)
            ->orderByDesc(
                Match::whereSubjectId($user->id)
                    ->whereColumn('object_id', ModelTable::USERS . '.id')
                    ->orderByDesc('chosen_at')
                    ->select('chosen_at')
                    ->limit(1)
            );
    }

    public function getMatchedUsersWithoutCommunicatedQuery(User $user)
    {
        return $this->getMatchedUsersQuery($user)
            ->whereDoesntHave('threads.participants', function ($query) use ($user) {
                /** @var Participant $query */
                $query->whereExistsSameThreadUserId($user->id, true);
            });
    }

    public function getItems(User $user, int $fromId = null)
    {
        $fromDateTime = null;

        if ($fromId) {
            $match = $this->getMatch($user->id, $fromId);
            if ($match) {
                $fromDateTime = $match->chosen_at;
            }
        }

        return $this->getMatchedUsersWithoutCommunicatedQuery($user)
            ->withSubjectMatchForObject($user->id)
            ->where(function ($query) use ($fromId, $fromDateTime) {
                /** @var Builder $query */
                if ($fromId && $fromDateTime) {
                    $query
                        ->where('id', '!=', $fromId)
                        ->whereDoesntHave('objectMatches', function ($query) use ($fromDateTime) {
                            /** @var Match $query */
                            $query->where('chosen_at', '>', $fromDateTime);
                        })
                        ->whereDoesntHave('subjectMatches', function ($query) use ($fromDateTime) {
                            /** @var Match $query */
                            $query->where('chosen_at', '>', $fromDateTime);
                        });
                }
            })
            ->limit(config('options.match.limit'))
            ->get();
    }

    public function getUserInfo(User $user, int $id)
    {
        $objectUser = ChoiceService::getUserChoiceQuery($user)
            ->whereHasMatches($user->id)
            ->find($id);

        if (!$objectUser) {
            throw new MatchUserNotFoundException(Lang::get('We are sorry, user not found.'));
        }

        $match = $this->getMatch($user->id, $id);
        $match->update([
            'is_visited' => true,
            'visited_at' => now()->toDateTimeString(),
        ]);

        return $objectUser;
    }

    public function delete(User $user, $id)
    {
        $match = $this->getMatch($user->id, $id);

        if ($match) {
            $match->delete();
            broadcast(new MatchDeleted($id, $user));
        }

        return [
            'id' => $id,
        ];
    }
}
