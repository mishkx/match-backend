<?php

namespace App\Contracts\Services;

use App\Models\Account\User;
use Illuminate\Database\Eloquent\Builder;

interface MatchContract
{
    /**
     * Запрос для получения подходящих по предпочтениям пользователей:
     * (по возрасту, полу, расстоянию).
     *
     * @param User $user
     * @return User|Builder
     */
    public function getPreferredUsersQuery(User $user);

    /**
     * Запрос для получения подходящих по предпочтениям новых, ранее не оцененных пользователей
     * и тех, кто не оценил негативно текущего пользователя.
     *
     * @param User $user
     * @return User|Builder
     */
    public function getPreferredNewUsersQuery(User $user);

    /**
     * Запрос для получения подходящих по предпочтениям новых, ранее не оцененных пользователей,
     * которые посещали сервис в недавнее время.
     *
     * @param User $user
     * @return User|Builder
     */
    public function getPreferredNewUsersWithRecentActivityQuery(User $user);

    /**
     * Запрос для получения взаимно оцененных пользователей.
     *
     * @param User $user
     * @return User|Builder
     */
    public function getMatchedUsersQuery(User $user);
}
