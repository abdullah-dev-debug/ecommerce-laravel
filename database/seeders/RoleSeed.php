<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                "name" => "admin",
                "status" => 1,
            ],
            [
                "name" => "vendor",
                "status" => 1,
            ],
            [
                "name" => "customer",
                "status" => 1,
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
