<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Http\Requests\Admin\Admins\AdminStoreRequest;
use App\Http\Requests\Admin\Admins\AdminUpdateRequest;
use App\Services\Admin\Admins\AdminService;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        $admins = Admin::with('roles')->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        // إخفاء super-admin من صفحة الإنشاء
        $roles = Role::where('name', '!=', 'super-admin')->get();

        return view('admin.admins.create', [
            'roles' => $roles,
        ]);
    }

    public function store(AdminStoreRequest $request)
    {
        $this->adminService->store($request->validated(), $request->roles);

        return redirect()->route('admin.admins.index')
            ->with('success', __('admin.admins.success_created'));
    }

    public function edit(Admin $admin)
    {
        // إخفاء super-admin من صفحة التعديل أيضًا
        $roles = Role::where('guard_name', 'admin')
                     ->where('name', '!=', 'super-admin')
                     ->get();

        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        $this->adminService->update($admin, $request->validated(), $request->roles);

        return redirect()->route('admin.admins.index')
            ->with('success', __('admin.admins.success_updated'));
    }

    public function destroy(Admin $admin)
    {
        $this->adminService->delete($admin);

        return redirect()->route('admin.admins.index')
            ->with('success', __('admin.admins.success_deleted'));
    }

    public function show(Admin $admin)
    {
        $role = $admin->roles->first();
        $permissions = $role ? $role->permissions : collect();

        return view('admin.admins.show', compact('admin', 'role', 'permissions'));
    }
}
