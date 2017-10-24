<?php

/** @var Factory $factory */

use App\Models\Category;
use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    $category = factory(Category::class)->create();

    return [
        'name' => $faker->unique()->text(16),
        'category_id' => $category->id
    ];
});
