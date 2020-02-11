<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Constants\UserConstants;
use App\Models\Account\User;
use Faker\Generator as Faker;
use Faker\Provider\Person;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $mapGenders = [
        UserConstants::GENDER_MALE => Person::GENDER_MALE,
        UserConstants::GENDER_FEMALE => Person::GENDER_FEMALE,
    ];

    $gender = $faker->randomElement([
        UserConstants::GENDER_MALE,
        UserConstants::GENDER_FEMALE,
    ]);

    return [
        'name' => $faker->firstName($mapGenders[$gender]),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'password_is_set' => true,
        'remember_token' => Str::random(10),
        'gender' => $gender,
        'born_on' => $faker
            ->dateTimeBetween(
                '-' . UserConstants::MAX_AGE . ' years',
                '-' . UserConstants::MIN_AGE . ' years'
            )
            ->format('Y-m-d'),
        'description' => $faker->text(50),
    ];
});
