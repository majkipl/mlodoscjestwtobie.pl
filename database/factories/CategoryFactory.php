<?php

/** @var Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->words(3, true);

    return [
        'name' => $name,
        'slug' => Str::slug($name)
    ];
});
