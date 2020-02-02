<?php

namespace App\Contracts\Services;

use App\Models\Account\User;
use Illuminate\Database\Eloquent\Builder;

interface RecommendationContract
{
    /**
     * Запрос для получения подходящих по предпочтениям пользователей:
     * (по возрасту, полу, расстоянию).
     *
     * @param User $user
     * @return User|Builder
     */
    public function getUsersQuery(User $user);

    /**
     * Запрос для получения подходящих по предпочтениям новых, ранее не оцененных пользователей
     * и тех, кто не оценил негативно текущего пользователя.
     *
     * @param User $user
     * @return User|Builder
     */
    public function getNewUsersQuery(User $user);

    public function getNewUsersWithRandomOrderQuery(User $user);

    /**
     * Запрос для получения подходящих по предпочтениям новых, ранее не оцененных пользователей,
     * которые посещали сервис в недавнее время.
     *
     * @param User $user
     * @return User|Builder
     */
    public function getNewUsersWithRecentActivityQuery(User $user);

    public function getItems(User $user);
}
