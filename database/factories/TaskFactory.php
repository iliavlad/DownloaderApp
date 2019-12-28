<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(),
        'url' => $faker->url,
        'status' => $faker->randomElement(Task::POSSIBLESTATUS),
        'local_path' => $faker->url,
        'added_by' => $faker->randomElement(Task::POSSIBLEADDEDBY),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
