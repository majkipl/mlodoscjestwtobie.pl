<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Whence;
use Faker\Generator as Faker;

$factory->define(Whence::class, function (Faker $faker) {
    return [
        'name' => $faker->words(3,true)
    ];
});
