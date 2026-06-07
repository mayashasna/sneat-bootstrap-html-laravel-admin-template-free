<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء دور السوبر أدمن
        $role = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'admin'
        ]);

        // إعطاء كل الصلاحيات لهذا الدور
        $role->syncPermissions(Permission::all());

        // جلب أول أدمن (السوبر أدمن)
        $admin = Admin::first();

        // إسناد الدور والصلاحيات له فقط
        if ($admin) {
            $admin->syncRoles(['super-admin']);
            $admin->syncPermissions(Permission::all());
        }
    }
}
