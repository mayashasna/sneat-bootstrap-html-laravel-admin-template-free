<?php

namespace App\Services\BusinessAccount;

use App\Models\BusinessAccount;

class BusinessAccountService
{
    /**
     * عرض حسابات الأعمال الخاصة بالمستخدم
     */
    public function index()
    {
        return BusinessAccount::where('user_id', auth('api')->id())
            ->latest()
            ->paginate(10);
    }

    /**
     * إنشاء حساب أعمال جديد
     */
    public function store(array $data): BusinessAccount
    {
        // إضافة user_id
        $data['user_id'] = auth('api')->id();

        // الحالة الافتراضية
        $data['status'] = 'Pending';

        // إنشاء الحساب بدون ملفات
        $businessAccount = BusinessAccount::create($data);

        // رفع الملفات إذا موجودة
        if (isset($data['documents']) && is_array($data['documents'])) {
            foreach ($data['documents'] as $file) {
                $businessAccount
                    ->addMedia($file)
                    ->toMediaCollection('documents');
            }
        }

        return $businessAccount;
    }

    /**
     * عرض حساب أعمال واحد
     */
   public function show($id)
{
    return BusinessAccount::with('receivedRatings')
        ->where('user_id', auth('api')->id())
        ->where('id', $id)
        ->firstOrFail();
}


    /**
     * تعديل حساب أعمال
     */
    public function update($id, array $data)
    {
        $businessAccount = BusinessAccount::where('user_id', auth('api')->id())
            ->where('id', $id)
            ->firstOrFail();

        // عند التعديل: يرجع الحساب لحالة Pending حسب شروط المشروع
        $data['status'] = 'Pending';

        // تحديث البيانات الأساسية
        $businessAccount->update($data);

        // إذا في ملفات جديدة
        if (isset($data['documents']) && is_array($data['documents'])) {

            // حذف الملفات القديمة قبل رفع الجديدة
            $businessAccount->clearMediaCollection('documents');

            foreach ($data['documents'] as $file) {
                $businessAccount
                    ->addMedia($file)
                    ->toMediaCollection('documents');
            }
        }

        return $businessAccount;
    }
    public function destroy($id)
{
    $account = BusinessAccount::where('user_id', auth('api')->id())->findOrFail($id);

    // حذف الملفات من Media Library
    $account->clearMediaCollection('documents');

    // حذف الحساب نفسه
    $account->delete();
}
public function restore($id)
{
    return BusinessAccount::onlyTrashed()
        ->where('user_id', auth('api')->id())
        ->where('id', $id)
        ->restore();
}

}
