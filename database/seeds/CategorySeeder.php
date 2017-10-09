<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $data[] = ['name' => 'Suszarki', 'slug' => 'suszarki'];
        $data[] = ['name' => 'Prostownice', 'slug' => 'prostownice'];
        $data[] = ['name' => 'Lokówki', 'slug' => 'lokowki'];
        $data[] = ['name' => 'Lokówko suszarki', 'slug' => 'lokowko-suszarki'];
        $data[] = ['name' => 'Zestaw do stylizacji', 'slug' => 'zestaw-do-stylizacji'];
        $data[] = ['name' => 'Wałki', 'slug' => 'walki'];
        $data[] = ['name' => 'Depilatory', 'slug' => 'depilatory'];
        $data[] = ['name' => 'Urządzenia IPL', 'slug' => 'urzadzenia-ipl'];
        $data[] = ['name' => 'Golarki i trymery damskie', 'slug' => 'golarki-i-trymery-damskie'];
        $data[] = ['name' => 'Zalotki do rzęs', 'slug' => 'zalotki-do-rzes'];
        $data[] = ['name' => 'Pilniki do stóp', 'slug' => 'pilniki-do-stop'];
        $data[] = ['name' => 'Szczotki do ciała', 'slug' => 'szczoteczki-do-ciala'];
        $data[] = ['name' => 'Szczoteczki do twarzy', 'slug' => 'szczoteczki-do-twarzy'];
        $data[] = ['name' => 'Szczoteczki do zębów', 'slug' => 'szczoteczki-do-zebow'];

        Category::insert($data);
    }
}
