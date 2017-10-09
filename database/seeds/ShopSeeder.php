<?php

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $data[] = ['name' => 'Agdwarszawa.pl'];
        $data[] = ['name' => 'Al.to'];
        $data[] = ['name' => 'Avans.pl'];
        $data[] = ['name' => 'Mambonus.pl'];
        $data[] = ['name' => 'Zakupy-eleclerc.pl'];
        $data[] = ['name' => 'Electro.pl'];
        $data[] = ['name' => 'Emag.pl'];
        $data[] = ['name' => 'Sklep.energa.pl'];
        $data[] = ['name' => 'Euro.com.pl'];
        $data[] = ['name' => 'Kakto.pl'];
        $data[] = ['name' => 'Komputronik.pl'];
        $data[] = ['name' => 'Mediadomek.pl'];
        $data[] = ['name' => 'Mediaexpert.pl'];
        $data[] = ['name' => 'Mediamarkt.pl'];
        $data[] = ['name' => 'Morele.net'];
        $data[] = ['name' => 'Neo24.pl'];
        $data[] = ['name' => 'Neonet.pl'];
        $data[] = ['name' => 'Oficjalny sklep Allegro'];
        $data[] = ['name' => 'OleOle.pl'];
        $data[] = ['name' => 'Sklep.payback.pl'];
        $data[] = ['name' => 'Saturn.pl'];
        $data[] = ['name' => 'Selgros24.pl'];
        $data[] = ['name' => 'Sklep stacjonarny'];
        $data[] = ['name' => 'Zadowolenie.pl'];
        $data[] = ['name' => 'Strefa.enea.pl'];
        $data[] = ['name' => 'Mycenter.pl'];
        $data[] = ['name' => 'Redcoon.pl'];
        $data[] = ['name' => 'Remington – Strefa Marek Allegro'];
        $data[] = ['name' => 'Juka.pl'];
        $data[] = ['name' => 'Partneragdrtv.com.pl'];

        Shop::insert($data);
    }
}
