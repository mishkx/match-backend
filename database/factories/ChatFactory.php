<?php

/** @var Factory $factory */

use App\Models\Account\User;
use App\Models\Chat\Message;
use App\Models\Chat\Participant;
use App\Models\Chat\Thread;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Thread::class, function (Faker $faker) {
    return [];
});

$factory->define(Participant::class, function (Faker $faker) {
    return [
        'thread_id' => factory(Thread::class),
        'user_id' => factory(User::class),
        'visited_at' => $faker->dateTimeThisMonth,
    ];
});

$factory->define(Message::class, function (Faker $faker) {
    $dateTime = $faker->dateTimeThisMonth();
    return [
        'participant_id' => factory(Participant::class),
        'content' => $faker->realText(),
        'updated_at' => $dateTime,
        'created_at' => $dateTime,
    ];
});

