<?php

namespace App\Services;

use App\Contracts\Services\ChoiceContract;
use App\Events\MatchCreated;
use App\Models\Account\User;
use Carbon\Carbon;
use UserService;

class ChoiceService implements ChoiceContract
{
    public function getUserChoiceQuery(User $user)
    {
        return UserService::query()
            ->withObjectMatchForSubject($user->id)
            ->withSubjectMatchForObject($user->id)
            ->withStateDistance($user);
    }

    //todo: проверки
    public function makeChoice(User $subjectUser, int $objectId, bool $isLiked)
    {
        $objectUser = UserService::getById($objectId);

        $match = $subjectUser->subjectMatches()->firstOrCreate([
            'object_id' => $objectUser->id,
        ]);

        $notChosen = is_null($match->chosen_at);

        if ($notChosen) {
            $match->update([
                'chosen_at' => Carbon::now(),
                'is_liked' => $isLiked,
            ]);
        }

        if ($isLiked) {
            $objectChoiceIsLiked = $objectUser->subjectMatches()
                ->where([
                    'object_id' => $subjectUser->id
                ])
                ->whereIsLiked()
                ->first();
            if ($objectChoiceIsLiked) {
                broadcast(new MatchCreated($objectUser->id, $this->getUserChoiceQuery($objectUser)
                    ->find($subjectUser->id)));
            }
        }

        return $this->getUserChoiceQuery($subjectUser)
            ->find($objectUser->id);
    }

    public function makeChoiceLike(User $subjectUser, int $objectId)
    {
        return $this->makeChoice($subjectUser, $objectId, true);
    }

    public function makeChoiceDislike(User $subjectUser, int $objectId)
    {
        return $this->makeChoice($subjectUser, $objectId, false);
    }
}
