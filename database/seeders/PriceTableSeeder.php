<?php

namespace Database\Seeders;

use App\Models\Prices;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $price = [
            [
                'min' => '1',
                'max' => '200',
                'slug' => '1-200',
            ],
            [
                'min' => '200',
                'max' => '500',
                'slug' => '200-500',
            ],
            [
                'min' => '500',
                'max' => '800',
                'slug' => '500-800',
            ],
            [
                'min' => '800',
                'max' => '1200',
                'slug' => '800-1200',
            ],
            [
                'min' => '1200',
                'max' => '1500',
                'slug' => '1200-1500',
            ],
            [
                'min' => '1500',
                'max' => '3000',
                'slug' => '1500-3000',
            ],
            [
                'min' => '3000',
                'max' => '5000',
                'slug' => '3000-5000',
            ],
            [
                'min' => '5000',
                'max' => '100000',
                'slug' => '5000-100000',
            ],
            [
                'min' => '100000',
                'max' => '500000',
                'slug' => '100000-500000',
            ],

        ];

        foreach ($price as $priceData) {
            Prices::create($priceData);
        }
    }
}
