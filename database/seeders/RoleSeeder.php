<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::updateOrCreate(
            ['name' => 'Admin'],
            ['description' => 'Administrator role with full permissions.']
        );

        Role::updateOrCreate(
            ['name' => 'User'],
            ['description' => 'Regular user role.']
        );
    }
}
