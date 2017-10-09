<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $data[] = ['name' => 'AC5913W', 'category_id' => 1];
        $data[] = ['name' => 'AC5099', 'category_id' => 1];
        $data[] = ['name' => 'AC5911', 'category_id' => 1];
        $data[] = ['name' => 'AC5999', 'category_id' => 1];
        $data[] = ['name' => 'AC5011', 'category_id' => 1];
        $data[] = ['name' => 'AC6120', 'category_id' => 1];
        $data[] = ['name' => 'AC8820', 'category_id' => 1];
        $data[] = ['name' => 'AC8000', 'category_id' => 1];
        $data[] = ['name' => 'AC8002', 'category_id' => 1];
        $data[] = ['name' => 'D5215GP', 'category_id' => 1];


        $data[] = ['name' => 'S8700', 'category_id' => 2];
        $data[] = ['name' => 'S9100', 'category_id' => 2];
        $data[] = ['name' => 'S8598', 'category_id' => 2];
        $data[] = ['name' => 'S8590', 'category_id' => 2];
        $data[] = ['name' => 'S8540', 'category_id' => 2];
        $data[] = ['name' => 'S7412', 'category_id' => 2];
        $data[] = ['name' => 'S9509', 'category_id' => 2];
        $data[] = ['name' => 'S9600', 'category_id' => 2];
        $data[] = ['name' => 'S9500', 'category_id' => 2];
        $data[] = ['name' => 'S8500', 'category_id' => 2];

        $data[] = ['name' => 'CI91X1', 'category_id' => 3];
        $data[] = ['name' => 'CI9132', 'category_id' => 3];
        $data[] = ['name' => 'CI606', 'category_id' => 3];
        $data[] = ['name' => 'CI8725', 'category_id' => 3];
        $data[] = ['name' => 'CI63E1', 'category_id' => 3];
        $data[] = ['name' => 'CI8319', 'category_id' => 3];
        $data[] = ['name' => 'CI9532', 'category_id' => 3];
        $data[] = ['name' => 'CI96Z1', 'category_id' => 3];
        $data[] = ['name' => 'CI9529', 'category_id' => 3];
        $data[] = ['name' => 'CI9539', 'category_id' => 3];

        $data[] = ['name' => 'AS8810', 'category_id' => 4];
        $data[] = ['name' => 'AS8110', 'category_id' => 4];
        $data[] = ['name' => 'AS1220', 'category_id' => 4];
        $data[] = ['name' => 'AS7051', 'category_id' => 4];
        $data[] = ['name' => 'CB8338', 'category_id' => 4];
        $data[] = ['name' => 'CB65A45', 'category_id' => 4];
        $data[] = ['name' => 'AS800', 'category_id' => 4];
        $data[] = ['name' => 'AS404', 'category_id' => 4];

        $data[] = ['name' => 'CI5219GPR', 'category_id' => 5];
        $data[] = ['name' => 'CI97M1', 'category_id' => 5];
        $data[] = ['name' => 'S8670', 'category_id' => 5];
        $data[] = ['name' => 'AS7055', 'category_id' => 5];

        $data[] = ['name' => 'H9096', 'category_id' => 6];
        $data[] = ['name' => 'H9100', 'category_id' => 6];
        $data[] = ['name' => 'KF40E', 'category_id' => 6];
        $data[] = ['name' => 'H0747', 'category_id' => 6];
        $data[] = ['name' => 'KF20i', 'category_id' => 6];
        $data[] = ['name' => 'H5670', 'category_id' => 6];
        $data[] = ['name' => 'H5600', 'category_id' => 6];

        $data[] = ['name' => 'EP7035', 'category_id' => 7];
        $data[] = ['name' => 'EP7030', 'category_id' => 7];
        $data[] = ['name' => 'EP7020', 'category_id' => 7];
        $data[] = ['name' => 'EP7010', 'category_id' => 7];

        $data[] = ['name' => 'IPL6780', 'category_id' => 8];
        $data[] = ['name' => 'IPL6750', 'category_id' => 8];
        $data[] = ['name' => 'IPL6500', 'category_id' => 8];
        $data[] = ['name' => 'IPL6250', 'category_id' => 8];
        $data[] = ['name' => 'IPL2000', 'category_id' => 8];

        $data[] = ['name' => 'WPG4010C', 'category_id' => 9];
        $data[] = ['name' => 'WPG4035', 'category_id' => 9];
        $data[] = ['name' => 'BKT4000', 'category_id' => 9];
        $data[] = ['name' => 'BKT3000C', 'category_id' => 9];
        $data[] = ['name' => 'WDF5030', 'category_id' => 9];
        $data[] = ['name' => 'WDF4840', 'category_id' => 9];
        $data[] = ['name' => 'MPT4000', 'category_id' => 9];
        $data[] = ['name' => 'WDF4815C', 'category_id' => 9];
        $data[] = ['name' => 'MPT4000C', 'category_id' => 9];
        $data[] = ['name' => 'MPT3800', 'category_id' => 9];

        $data[] = ['name' => 'EC300GP', 'category_id' => 10];
        $data[] = ['name' => 'EC300', 'category_id' => 10];

        $data[] = ['name' => 'CR4000', 'category_id' => 11];

        $data[] = ['name' => 'BB1000', 'category_id' => 12];

        $data[] = ['name' => 'FC1000', 'category_id' => 13];
        $data[] = ['name' => 'FC1000GP', 'category_id' => 13];
        $data[] = ['name' => 'FC500', 'category_id' => 13];
        $data[] = ['name' => 'MD3000', 'category_id' => 13];

        $data[] = ['name' => 'SFT-150', 'category_id' => 14];
        $data[] = ['name' => 'SFT-100', 'category_id' => 14];

        Product::insert($data);
    }
}
