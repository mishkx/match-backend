<?php

use App\Constants\UserConstants;
use App\Models\Account\Preference;
use App\Models\Account\State;
use App\Models\Account\User;
use App\Traits\FakerTrait;
use Illuminate\Database\Seeder;

class FakeUserSeeder extends Seeder
{
    use FakerTrait;

    private const USERS_COUNT = 1000;
    private const USERS_CHUNK_SIZE = 100;

    public function run()
    {
        $this->createUsers();
    }

    private function createUsers()
    {
        $count = self::USERS_COUNT;

        while ($count > 0) {
            $chunk = $count < self::USERS_CHUNK_SIZE ? $count : self::USERS_CHUNK_SIZE;
            $count -= $chunk;

            factory(User::class, $chunk)->create()->each(function (User $user) {
                $this->createUser($user);
            });
        }
    }

    private function createUser(User $user)
    {
        $ageDiff = 5;
        $age = $user->born_on->diffInYears();
        $ageFrom = $this->faker()->numberBetween(UserConstants::MIN_AGE, $age - $ageDiff);
        $ageFrom = $ageFrom < UserConstants::MIN_AGE ? UserConstants::MIN_AGE : $ageFrom;
        $ageTo = $this->faker()->numberBetween($ageFrom, $age + $ageDiff);

        $gender = collect([
            UserConstants::GENDER_MALE,
            UserConstants::GENDER_FEMALE,
        ])->reject(function ($value) use ($user) {
            return $value === $user->gender;
        })->first();

        $user->preference()->save(factory(Preference::class)->make([
            'age_from' => $ageFrom,
            'age_to' => $ageTo,
            'gender' => $gender,
        ]));

        $user->state()->save(factory(State::class)->make());
    }
}
