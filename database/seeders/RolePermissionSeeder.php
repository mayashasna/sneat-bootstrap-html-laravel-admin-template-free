<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Super Admin → كل الصلاحيات
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);
        $superAdmin->syncPermissions(Permission::all());

        // 2) Admin → صلاحيات إدارية واسعة
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);

        $adminPermissions = [

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
              'view-conversations',
        ];

        $admin->syncPermissions($adminPermissions);

        // 3) Moderator → صلاحيات مراجعة فقط
        $moderator = Role::firstOrCreate(['name' => 'moderator', 'guard_name' => 'admin']);

        $moderatorPermissions = [
            'approve-business',
            'reject-business',

            'approve-service',
            'reject-service',

            'manage-reports',
        ];

        $moderator->syncPermissions($moderatorPermissions);
    }
}
