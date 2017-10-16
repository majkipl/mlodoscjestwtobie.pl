<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $data[] = [
            'name' => 'admin',
            'email' => 'admin@example.com',
            'role' => UserRole::ADMIN,
            'email_verified_at' => now(),
            'password' => Hash::make('asd123'), // password
            'remember_token' => Str::random(10),
            'api_token' => Str::random(60),
        ];

        User::insert($data);
    }
}
