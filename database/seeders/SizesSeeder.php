<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sizes;

class SizesSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            [
                'name' => 'Small',
                'code' => 'S',
                'description' => 'Small size',
                'slug' => 'small',
                'status' => 1
            ],
            [
                'name' => 'Medium',
                'code' => 'M',
                'description' => 'Medium size',
                'slug' => 'medium',
                'status' => 1
            ],
            [
                'name' => 'Large',
                'code' => 'L',
                'description' => 'Large size',
                'slug' => 'large',
                'status' => 1
            ],
            [
                'name' => 'Extra Large',
                'code' => 'XL',
                'description' => 'Extra Large size',
                'slug' => 'xl',
                'status' => 1
            ],
            [
                'name' => 'Double Extra Large',
                'code' => 'XXL',
                'description' => 'Double Extra Large size',
                'slug' => 'xxl',
                'status' => 1
            ],
        ];

        foreach ($sizes as $size) {
            Sizes::firstOrCreate(
                ['slug' => $size['slug']],
                $size
            );
        }
    }
}
