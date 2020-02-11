<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account\Match;
use Faker\Generator as Faker;

$factory->define(Match::class, function (Faker $faker) {
    return [
        'is_liked' => $faker->boolean(40),
        'chosen_at' => $faker->dateTimeThisMonth,
    ];
});
