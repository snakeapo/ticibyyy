<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'avatar' => 'avatar.png',
            'name' => 'Softby',
            'surname' => 'net',
            'balance' => '0',
            'role' => 'admin',
            'identy' => '2290',
            'user_phone' => '5376818046',
            'user_address'=> '5 nisan mahallesi',
            'email'=> 'admin@softby.net',
            'sex'=> 'male',
            'password'=> bcrypt('password'),
        ]);
    }
}
