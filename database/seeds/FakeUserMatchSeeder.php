<?php

use App\Models\Account\Match;
use App\Models\Account\User;
use App\Traits\FakerTrait;
use Illuminate\Database\Seeder;

class FakeUserMatchSeeder extends Seeder
{
    use FakerTrait;

    private const USER_MAX_MATCHES = 50;

    public function run()
    {
        $this->createMatches();
    }

    private function createMatches()
    {
        $continue = true;

        while ($continue) {

            $user = User::query()
                ->with([
                    'preference',
                    'state',
                ])
                ->whereDoesntHave('subjectMatches')
                ->inRandomOrder()
                ->first();

            if (!$user) {
                $continue = false;
                return;
            }

            $objects = MatchService::getPreferredUsersQuery($user)
                ->inRandomOrder()
                ->limit($this->faker()->numberBetween(1, self::USER_MAX_MATCHES))
                ->get();

            if (!$objects->count()) {
                $continue = false;
                return;
            }

            $objects->each(function (User $object) use ($user) {
                $dateTimeFrom = $object->created_at->gt($user->created_at)
                    ? $object->created_at
                    : $user->created_at;

                factory(Match::class)->create([
                    'subject_id' => $user->id,
                    'object_id' => $object->id,
                    'marked_at' => $this->faker()->dateTimeBetween($dateTimeFrom, now()),
                ]);
            });

            $user->state->update([
                'updated_at' => $user->subjectMatches->max('marked_at'),
            ]);
        }
    }
}
