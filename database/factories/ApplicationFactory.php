<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Whence;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

$factory->define(\App\Models\Application::class, function (Faker $faker) {

    $maxDate = Carbon::now()->subYears(18)->subDay(); // Odejmuje 18 lat i 1 dzień
    $category = \factory(Category::class)->create();
    $product = \factory(Product::class)->create();
    $shop = \factory(Shop::class)->create();
    $whence = \factory(Whence::class)->create();

    $contest = $faker->boolean;

    $obj = [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'birthday' => $faker->dateTimeBetween($maxDate)->format('d-m-Y'),
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'zip' => $faker->numberBetween(10,99) . '-' . $faker->numberBetween(100,999),
        'email' => $faker->unique()->safeEmail,
        'phone' => '+48' . $faker->numberBetween('123456789', '999999999'),
        'receiptnb' => $faker->randomNumber(),
        'img_receipt' => 'tips/z8cQ1QnxrY6BlXkKZeTNN5WFzciIzVuRFDmfWEvu.jpg',
        'img_ean' => 'tips/z8cQ1QnxrY6BlXkKZeTNN5WFzciIzVuRFDmfWEvu.jpg',
        'legal_1' => true,
        'legal_2' => true,
        'legal_3' => true,
        'legal_4' => true,
//        'token' => Str::random(32),
        'category_id' => $category->id,
        'product_id' => $product->id,
        'shop_id' => $shop->id,
        'whence_id' => $whence->id,
    ];

    if( $contest ) {
        $obj['contest'] = $contest;

        $obj['title'] = $faker->text(128);
        $obj['message'] = $faker->text(500);

        switch ($faker->numberBetween(1,3))
        {
            case 1: // image
                $obj['img_tip'] = 'tips/8pUyERZHyUpcKu8e0Cd5krzDolWb8P9vzm469AaP.jpg';
                break;
            case 2: // youtube
                $obj['video_url'] = 'https://www.youtube.com/watch?v=u3z2Du1cPhQ';
                $obj['video_type'] = 'youtube';
                $obj['video_id'] = 'u3z2Du1cPhQ';
                $obj['video_image_id'] = 'https://img.youtube.com/vi/u3z2Du1cPhQ/default.jpg';
                break;
            case 3: //vimeo
                $obj['video_url'] = 'https://vimeo.com/19568852';
                $obj['video_type'] = 'vimeo';
                $obj['video_id'] = '19568852';
                $obj['video_image_id'] = 'https://i.vimeocdn.com/video/124129987-95f23da9ca798369e00ad9d61fe7bdd02507358ef4dc8aa49841d74da26c13c2-d_640';
                break;
        }
    }

    return $obj;
});
