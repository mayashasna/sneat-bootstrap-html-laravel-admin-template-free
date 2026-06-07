<?php

namespace App\Services\Admin;

use App\Models\ActivityType;
use App\Models\BusinessAccount;
use App\Models\City;

class BusinessAccountService
{
    // جلب الحسابات مع العلاقات
    public function getAll()
    {
        return BusinessAccount::with(['user', 'activityType', 'city'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    // قبول حساب أعمال
    public function approve($id)
    {
        $account = BusinessAccount::findOrFail($id);
        $account->status = 'Approved';
        $account->save();

        return $account;
    }

    // رفض حساب أعمال
  public function reject($id, $reason)
{
    $account = BusinessAccount::findOrFail($id);

    $account->status = 'Rejected';
    $account->rejection_reason = $reason;
    $account->save();
}


    public function getRejected()
{
    return BusinessAccount::where('status', 'Rejected')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
}
public function edit($id)
{
    $account = BusinessAccount::findOrFail($id);

    $activityTypes = ActivityType::all();
    $cities = City::all();

    return view('admin.business-accounts.edit', compact('account', 'activityTypes', 'cities'));
}
public function update($request, $id)
{
    $account = BusinessAccount::findOrFail($id);

    $account->name_ar = $request->name_ar;
    $account->name_en = $request->name_en;
    $account->activity_type_id = $request->activity_type_id;
    $account->city_id = $request->city_id;
    $account->details = $request->details;
    $account->latitude = $request->latitude;
    $account->longitude = $request->longitude;

    // رفع مستندات جديدة
    if ($request->hasFile('documents')) {
        $docs = [];

        foreach ($request->file('documents') as $file) {
            $path = $file->store('business_documents', 'public');

            $docs[] = [
                'name' => $file->getClientOriginalName(),
                'url'  => asset('storage/' . $path),
            ];
        }

        // دمج المستندات القديمة مع الجديدة
        $account->documents = array_merge($account->documents ?? [], $docs);
    }

    $account->save();

    return $account;
}
public function delete($id)
{
    $account = BusinessAccount::findOrFail($id);
    $account->delete();
}
public function getDeleted()
{
    return BusinessAccount::onlyTrashed()
        ->with(['user', 'activityType', 'city'])
        ->orderBy('deleted_at', 'desc')
        ->paginate(10);
}
public function restore($id)
{
    $account = BusinessAccount::onlyTrashed()->findOrFail($id);
    $account->restore();

    return $account;
}

}
