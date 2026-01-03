<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name' => 'Black',  'slug' => 'black',  'code' => '#000000', 'status' => 1],
            ['name' => 'White',  'slug' => 'white',  'code' => '#FFFFFF', 'status' => 1],
            ['name' => 'Red',    'slug' => 'red',    'code' => '#FF0000', 'status' => 1],
            ['name' => 'Blue',   'slug' => 'blue',   'code' => '#0000FF', 'status' => 1],
            ['name' => 'Green',  'slug' => 'green',  'code' => '#008000', 'status' => 1],
            ['name' => 'Silver', 'slug' => 'silver', 'code' => '#C0C0C0', 'status' => 1],
            ['name' => 'Gold',   'slug' => 'gold',   'code' => '#FFD700', 'status' => 1],
        ];

        foreach ($colors as $color) {
            Color::firstOrCreate(
                ['slug' => $color['slug']],
                $color
            );
        }
    }
}
