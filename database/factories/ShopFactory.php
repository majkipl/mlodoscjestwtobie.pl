<?php

/** @var Factory $factory */

use App\Models\Shop;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Shop::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
