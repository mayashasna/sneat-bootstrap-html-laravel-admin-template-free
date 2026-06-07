<?php

namespace App\Services\Admin;


use Spatie\Permission\Models\Role;

class RoleService
{
    public function getAll()
    {
        return Role::where('guard_name', 'admin')->get();
    }

    public function create(array $data)
{
    return Role::create([
        'name' => $data['name'],
        'display_name' => $data['name'], // أو أي قيمة بدك ياها
        'guard_name' => 'admin',
    ]);
}
public function find($id)
{
    return \Spatie\Permission\Models\Role::findOrFail($id);
}
public function update($role, array $data)
{
    $role->update([
        'name' => $data['name'],
        'display_name' => $data['display_name'] ?? $data['name'],
    ]);

    return $role;
}



}
