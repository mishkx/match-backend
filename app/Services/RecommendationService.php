<?php

namespace App\Services;

use App\Constants\ModelTable;
use App\Constants\UserConstants;
use App\Contracts\Services\RecommendationContract;
use App\Models\Account\Match;
use App\Models\Account\State;
use App\Models\Account\User;

class RecommendationService implements RecommendationContract
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getUsersQuery(User $user)
    {
        return $this->model
            ->whereAgeBetween($user->preference->age_from, $user->preference->age_to)
            ->whereHas('state', function ($query) use ($user) {
                /** @var State $query */
                $query->distanceSphere(
                    'location',
                    $user->state->location,
                    $user->preference->max_distance * UserConstants::DISTANCE_MULTIPLIER
                );
            })
            ->whereGender($user->preference->gender)
            ->withStateDistance($user)
            ->where('id', '!=', $user->id);
    }

    public function getNewUsersQuery(User $user)
    {
        // todo: добавить сортировку по новым
        return $this->getUsersQuery($user)
            /**
             * Пользователь не оценивал других пользователей.
             */
            ->whereDoesntHave('objectMatches', function ($query) use ($user) {
                /** @var Match $query */
                $query->whereSubjectId($user->id);
            })
            ->where(function ($query) use ($user) {
                /** @var User $query */
                $query
                    /**
                     * Пользователя не оценили негативно другие пользователи.
                     */
                    ->whereDoesntHave('subjectMatches', function ($query) use ($user) {
                        /** @var Match $query */
                        $query
                            ->whereDoesntLike()
                            ->whereObjectId($user->id);
                    })
                    /**
                     * Пользователя оценили негативно другие пользователи, но истек период.
                     */
                    ->orWhereHas('subjectMatches', function ($query) use ($user) {
                        /** @var Match $query */
                        $query
                            ->whereRenewalPeriodHasCome()
                            ->whereDoesntLike()
                            ->whereObjectId($user->id);
                    });
            });
    }

    public function getNewUsersWithRandomOrderQuery(User $user)
    {
        // todo: отрефакторить запрос
        return $this->getNewUsersQuery($user)
            ->orderByRaw(
                'IF(('
                . Match::whereObjectId($user->id)
                    ->whereColumn('subject_id', ModelTable::USERS . '.id')
                    ->orderByDesc('is_liked')
                    ->select('is_liked')
                    ->limit(1)
                    ->toRawSql()
                . ') IS NULL, 0.5, 1) + RAND() DESC'
            );
    }

    public function getNewUsersWithRecentActivityQuery(User $user)
    {
        return $this->getNewUsersWithRandomOrderQuery($user)
            ->whereHas('state', function ($query) use ($user) {
                /** @var State $query */
                $query->whereRecentlyPresent();
            });
    }

    public function getItems(User $user)
    {
        return $this->getNewUsersWithRecentActivityQuery($user)->limit(
            config('options.match.recommendationItemsLimit')
        )->get();
    }
}
