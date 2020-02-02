<?php

namespace App\Contracts\Services;

use App\Models\Account\User;
use Illuminate\Database\Eloquent\Builder;

interface ChoiceContract
{
    /**
     * Запрос для получения пользователя с его оценками и состоянием.
     *
     * @param User $user
     * @return User|Builder
     */
    public function getUserChoiceQuery(User $user);

    public function makeChoice(User $subjectUser, int $objectId, bool $isLiked);

    public function makeChoiceLike(User $subjectUser, int $objectId);

    public function makeChoiceDislike(User $subjectUser, int $objectId);
}
