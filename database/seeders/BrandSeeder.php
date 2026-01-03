<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            // Smart Phones
            ['name' => 'NovaTech',   'slug' => 'novatech',   'status' => 1],
            ['name' => 'ZenMobile',  'slug' => 'zenmobile',  'status' => 1],
            ['name' => 'Pixelon',    'slug' => 'pixelon',    'status' => 1],

            // Smart Watches
            ['name' => 'TimeXo',     'slug' => 'timexo',     'status' => 1],
            ['name' => 'PulseFit',   'slug' => 'pulsefit',   'status' => 1],
            ['name' => 'AuraTime',   'slug' => 'auratime',   'status' => 1],

            // Accessories
            ['name' => 'Gearify',    'slug' => 'gearify',    'status' => 1],
            ['name' => 'Wirex',      'slug' => 'wirex',      'status' => 1],
            ['name' => 'TechNest',   'slug' => 'technest',   'status' => 1],

            // Speakers
            ['name' => 'Soundora',   'slug' => 'soundora',   'status' => 1],
            ['name' => 'Bassify',    'slug' => 'bassify',    'status' => 1],
            ['name' => 'EchoBeat',   'slug' => 'echobeat',   'status' => 1],

            // Cameras
            ['name' => 'SnapPro',    'slug' => 'snappro',    'status' => 1],
            ['name' => 'Lensify',    'slug' => 'lensify',    'status' => 1],
            ['name' => 'Camora',     'slug' => 'camora',     'status' => 1],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(
                ['slug' => $brand['slug']],
                $brand
            );
        }
    }
}
