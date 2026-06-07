<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Services\Admin\RoleService;
use Illuminate\Http\Request; // ← هذا هو الريكوست الصحيح

class RoleController extends Controller
{
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;

        // حماية الصلاحيات حسب نوع العملية
        $this->middleware('permission:view roles')->only('index');              // عرض قائمة الأدوار
        $this->middleware('permission:create roles')->only(['create', 'store']); // إنشاء دور جديد
        $this->middleware('permission:update roles')->only(['edit', 'update']);  // تعديل الدور
        $this->middleware('permission:delete roles')->only('destroy');           // حذف الدور
        $this->middleware('permission:assign role permissions')->only('permissions'); // إدارة صلاحيات الدور
    }

    // ---------------------------------------------------------
    // عرض جميع الأدوار
    // ---------------------------------------------------------
    public function index()
    {
        // جلب كل الأدوار من الخدمة
        $roles = $this->service->getAll();

        // عرض صفحة قائمة الأدوار
        return view('admin.roles.index', compact('roles'));
    }

    // ---------------------------------------------------------
    // عرض صفحة إنشاء دور جديد
    // ---------------------------------------------------------
    public function create()
    {
        return view('admin.roles.create');
    }

    // ---------------------------------------------------------
    // حفظ الدور الجديد في قاعدة البيانات
    // ---------------------------------------------------------
    public function store(StoreRoleRequest $request)
    {
        // إرسال البيانات إلى الخدمة لإنشاء الدور
        $this->service->create($request->validated());

        return redirect()->route('admin.roles.index')
            ->with('success', __('menu.role_created'));
    }

    // ---------------------------------------------------------
    // عرض صفحة إدارة صلاحيات دور معيّن
    // ---------------------------------------------------------
    public function permissions($id)
    {
        // جلب الدور المطلوب
        $role = $this->service->find($id);

        // جلب جميع الصلاحيات الموجودة بالنظام
        $permissions = \Spatie\Permission\Models\Permission::all();

        // عرض صفحة إدارة الصلاحيات
        return view('admin.roles.permissions', compact('role', 'permissions'));
    }

    // ---------------------------------------------------------
    // تحديث صلاحيات الدور
    // ---------------------------------------------------------
    public function updatePermissions(Request $request, $id)
    {
        // جلب الدور المطلوب
        $role = $this->service->find($id);

        // ربط الصلاحيات المختارة بالدور
        // إذا ما تم اختيار أي صلاحية → يتم إرسال مصفوفة فارغة
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', 'تم تحديث صلاحيات الدور بنجاح');
    }
    // تحديث  الدور

public function edit($id)
{
    // جلب الدور المطلوب تعديله
    $role = $this->service->find($id);

    // عرض صفحة تعديل الدور
    return view('admin.roles.edit', compact('role'));
}
public function update(UpdateRoleRequest $request, $id)
{
    $role = $this->service->find($id);

    $this->service->update($role, $request->validated());

    return redirect()->route('admin.roles.index')
        ->with('success', 'تم تعديل الدور بنجاح');
}

public function destroy($id)
{
    $role = $this->service->find($id);

    // حذف الدور
    $role->delete();

    return redirect()->route('admin.roles.index')
        ->with('success', 'تم حذف الدور بنجاح');
}



}
