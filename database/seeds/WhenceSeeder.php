<?php

use App\Models\Whence;
use Illuminate\Database\Seeder;

class WhenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $data[] = ['name' => 'BLOGOSFERA'];
        $data[] = ['name' => 'FACEBOOK'];
        $data[] = ['name' => 'INSTAGRAM'];
        $data[] = ['name' => 'MAIL W SKRZYNCE'];
        $data[] = ['name' => 'PORTALE KONKURSOWE'];
        $data[] = ['name' => 'REKLAMA ONLINE'];
        $data[] = ['name' => 'ULOTKI I PLAKATY W SKLEPIE STACJONARNYM'];
        $data[] = ['name' => 'INFORMACJA W SKLEPIE INTERNETOWYM'];

        Whence::insert($data);
    }
}
