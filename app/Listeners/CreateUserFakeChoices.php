<?php

namespace App\Listeners;

use App\Models\Account\Match;
use App\Models\Account\User;
use App\Presenters\UserPresenter;
use App\Traits\FakerTrait;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use RecommendationService;
use UserService;

class CreateUserFakeChoices implements ShouldQueue
{
    use InteractsWithQueue, FakerTrait;

    private const MAX_CHOICES_COUNT = 200;
    protected $user;

    public function handle(Login $event)
    {
        $user = UserService::getById($event->user->getAuthIdentifier());

        $presenter = new UserPresenter($user);

        if (
            config('options.faker')
            && !$user->objectMatches->count()
            && $presenter->getDataIsFilled()
        ) {
            $this->createChoices($user);
        }
    }

    private function createChoices(User $user)
    {
        Match::query()
            ->where('object_id', $user->id)
            ->forceDelete();

        $users = RecommendationService::getUsersQuery($user)
            ->inRandomOrder()
            ->limit($this->faker()->numberBetween(floor(self::MAX_CHOICES_COUNT / 2), self::MAX_CHOICES_COUNT))
            ->get();

        if (!$users->count()) {
            return;
        }

        $users->each(function (User $subject) use ($user) {
            $dateTimeFrom = $subject->created_at->gt($user->created_at)
                ? $subject->created_at
                : $user->created_at;

            factory(Match::class)->create([
                'subject_id' => $subject->id,
                'object_id' => $user->id,
                'chosen_at' => $this->faker()->dateTimeBetween($dateTimeFrom, now()),
            ]);
        });

        $user->state->update([
            'updated_at' => $user->subjectMatches->max('chosen_at'),
        ]);
    }
}
