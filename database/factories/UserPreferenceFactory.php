<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Constants\UserConstants;
use App\Models\Account\Preference;
use Faker\Generator as Faker;

$factory->define(Preference::class, function (Faker $faker) {
    $ageDiff = 5;
    $age = $faker->numberBetween(UserConstants::MIN_AGE, UserConstants::MAX_AGE);
    $ageFrom = $faker->numberBetween(UserConstants::MIN_AGE, $age - $ageDiff);
    $ageFrom = $ageFrom < UserConstants::MIN_AGE ? UserConstants::MIN_AGE : $ageFrom;
    $ageTo = $faker->numberBetween($ageFrom, $age + $ageDiff);

    return [
        'age_from' => $ageFrom,
        'age_to' => $ageTo,
        'max_distance' => $faker->numberBetween(10, 80),
        'gender' => $faker->randomElement([
            UserConstants::GENDER_MALE,
            UserConstants::GENDER_FEMALE,
        ]),
    ];
});
