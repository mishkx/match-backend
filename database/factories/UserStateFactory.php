<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account\State;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;

$factory->define(State::class, function (Faker $faker) {
    return [
        'ip_address' => $faker->ipv4,
        'location' => new Point(
            $faker->randomFloat(8, 55.55, 55.9),
            $faker->randomFloat(8, 37.34, 37.9)
        ),
        'is_accurate' => $faker->boolean(95),
    ];
});
