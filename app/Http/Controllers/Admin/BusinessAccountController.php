<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BusinessAccount\ApproveBusinessAccountRequest;
use App\Http\Requests\Admin\BusinessAccount\RejectBusinessAccountRequest;
use App\Models\ActivityType;
use App\Services\Admin\BusinessAccountService;
use App\Models\BusinessAccount;
use App\Models\City;

class BusinessAccountController extends Controller
{
    protected $service;

    public function __construct(BusinessAccountService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $accounts = BusinessAccount::with(['user', 'activityType', 'city'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // ✅ Pagination

        return view('admin.business-accounts.index', compact('accounts'));
    }

    public function show($id)
    {
        $account = BusinessAccount::with(['activityType', 'city', 'user', 'media'])
            ->findOrFail($id);

        return view('admin.business-accounts.show', compact('account'));
    }

    public function approve(ApproveBusinessAccountRequest $request)
    {
        $this->service->approve($request->id);

        return redirect()
            ->route('admin.business-accounts.index')
            ->with('success', 'Business account approved successfully.');
    }

    public function reject(Request $request)
    {
        $this->service->reject($request->id, $request->reason);

        return redirect()
            ->route('admin.business-accounts.index')
            ->with('success', 'Business account rejected successfully.');
    }

    public function rejected()
    {
        $accounts = $this->service->getRejected()->paginate(10); // ✅ Pagination

        return view('admin.business-accounts.rejected', compact('accounts'));
    }

    public function edit($id)
    {
        $account = BusinessAccount::findOrFail($id);

        $activityTypes = ActivityType::all();
        $cities = City::all();

        return view('admin.business-accounts.edit', compact('account', 'activityTypes', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $this->service->update($request, $id);

        return redirect()
            ->route('admin.business-accounts.show', $id)
            ->with('success', 'Business account updated successfully.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()
            ->route('admin.business-accounts.index')
            ->with('success', 'Business account deleted successfully.');
    }

    public function map($id)
    {
        $business = BusinessAccount::findOrFail($id);

        return view('admin.business-accounts.map', [
            'lat' => $business->latitude,
            'lng' => $business->longitude,
            'business' => $business,
        ]);
    }

    public function deleted()
    {
        $accounts = $this->service->getDeleted()->paginate(10); // ✅ Pagination

        return view('admin.business-accounts.deleted', compact('accounts'));
    }

    public function restore($id)
    {
        $this->service->restore($id);

        return redirect()
            ->route('admin.business-accounts.deleted')
            ->with('success', __('business.restored_success'));
    }
}
