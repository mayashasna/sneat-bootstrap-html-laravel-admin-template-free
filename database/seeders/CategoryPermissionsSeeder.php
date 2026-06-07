<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CategoryPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view-categories',
            'create-categories',
            'update-categories',
            'delete-categories',

            'view-subcategories',
            'create-subcategories',
            'update-subcategories',
            'delete-subcategories',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }

        $roles = Role::whereIn('name', ['super-admin', 'admin'])->get();

        foreach ($roles as $role) {
            $role->givePermissionTo($permissions);
        }
    }
}
