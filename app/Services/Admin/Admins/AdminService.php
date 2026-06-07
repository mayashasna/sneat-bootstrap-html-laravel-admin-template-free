<?php

namespace App\Services\Admin\Admins;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public function store(array $data, $roles): Admin
    {
        $admin = Admin::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'status'   => $data['status'],
        ]);

        if (!empty($roles)) {
            $admin->syncRoles($roles);
        }

        return $admin;
    }

    public function update(Admin $admin, array $data, $roles): Admin
    {
        $admin->update([
            'name'   => $data['name'],
            'email'  => $data['email'],
            'status' => $data['status'],
        ]);

        if (!empty($roles)) {
            $admin->syncRoles($roles);
        }

        return $admin;
    }

    public function delete(Admin $admin): void
    {
        $admin->delete();
    }
}
