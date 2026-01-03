<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            // Quantity
            ['name' => 'Piece',    'symbol' => 'pc', 'type' => 'quantity', 'status' => 1],

            // Weight
            ['name' => 'Kilogram', 'symbol' => 'kg', 'type' => 'weight',   'status' => 1],
            ['name' => 'Gram',     'symbol' => 'g',  'type' => 'weight',   'status' => 1],

            // Length
            ['name' => 'Meter',    'symbol' => 'm',  'type' => 'length',   'status' => 1],
            ['name' => 'Centimeter','symbol'=> 'cm', 'type' => 'length',  'status' => 1],

            // Volume
            ['name' => 'Liter',    'symbol' => 'l',  'type' => 'volume',   'status' => 1],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(
                ['symbol' => $unit['symbol']],
                $unit
            );
        }
    }
}
