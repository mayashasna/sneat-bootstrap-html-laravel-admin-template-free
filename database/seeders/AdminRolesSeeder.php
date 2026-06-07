<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminRolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(
    ['name' => 'super-admin', 'guard_name' => 'admin'],
    ['display_name' => 'Super Admin']
);

Role::firstOrCreate(
    ['name' => 'admin', 'guard_name' => 'admin'],
    ['display_name' => 'Admin']
);

Role::firstOrCreate(
    ['name' => 'moderator', 'guard_name' => 'admin'],
    ['display_name' => 'Moderator']
);

    }
}
