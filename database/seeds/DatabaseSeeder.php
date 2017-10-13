<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            ShopSeeder::class,
            WhenceSeeder::class,
            ProductSeeder::class,
            ApplicationSeeder::class,
//            PromotionSeeder::class,
//            UserSeeder::class
        ]);
    }
}
