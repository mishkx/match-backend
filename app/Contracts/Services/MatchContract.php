<?php

namespace App\Contracts\Services;

use App\Models\Account\User;
use Illuminate\Database\Eloquent\Builder;

interface MatchContract
{
    public function getMatch(int $subjectId, int $objectId);

    /**
     * Запрос для получения взаимно оцененных пользователей.
     *
     * @param User $user
     * @return User|Builder
     */
    public function getMatchedUsersQuery(User $user);

    public function getMatchedUsersWithoutCommunicatedQuery(User $user);

    public function getItems(User $user, int $fromId = null);

    public function getUserInfo(User $user, int $id);

    public function delete(User $user, $id);
}
