<?php

namespace Database\Seeders;

use App\Models\Ranges;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RangeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $range = [
            [
                'min' => '0',
                'max' => '5',
                'slug' => '0-5',
            ],
            [
                'min' => '5',
                'max' => '10',
                'slug' => '5-10',
            ],
            [
                'min' => '10',
                'max' => '15',
                'slug' => '10-15',
            ],
            [
                'min' => '15',
                'max' => '25',
                'slug' => '15-25',
            ],
            [
                'min' => '25',
                'max' => '50',
                'slug' => '25-50',
            ],
            [
                'min' => '50',
                'max' => '100',
                'slug' => '50-100',
            ],

        ];

        foreach ($range as $rangeData) {
            Ranges::create($rangeData);
        }
    }
}
