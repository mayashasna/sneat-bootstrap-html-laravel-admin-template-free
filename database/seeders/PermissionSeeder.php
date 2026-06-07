<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // Business Accounts
            'view-business',
            'approve-business',
            'reject-business',

            // Services
            'approve-service',
            'reject-service',

            // Categories
            'view-categories',
            'create-categories',
            'update-categories',
            'delete-categories',

            // Subcategories
            'view-subcategories',
            'create-subcategories',
            'update-subcategories',
            'delete-subcategories',

            // Dynamic Fields
            'create-dynamic-field',
            'update-dynamic-field',
            'delete-dynamic-field',

            // Cities
            'view-city',
            'create-city',
            'edit-city',
            'delete-city',
            'enable-city',
            'disable-city',

            // Slider + Reports
            'manage-slider',
            'manage-reports',

            // Admins
            'view admins',
            'create admins',
            'update admins',
            'delete admins',

            // Roles
            'view roles',
            'create roles',
            'update roles',
            'delete roles',
            'assign role permissions',
            // Conversations (🔥 جديد)
    'view-conversations',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }
    }
}
