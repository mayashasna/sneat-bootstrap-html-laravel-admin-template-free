<?php

namespace App\Http\Controllers\BusinessAccount;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessAccount\StoreBusinessAccountRequest;
use App\Http\Requests\BusinessAccount\UpdateBusinessAccountRequest;
use App\Services\BusinessAccount\BusinessAccountService;
use App\Traits\ApiResponse;
use App\Http\Resources\BusinessAccountResource;
use App\Models\BusinessAccount;

class BusinessAccountController extends Controller
{
    use ApiResponse;

    protected BusinessAccountService $service;

    public function __construct(BusinessAccountService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $accounts = $this->service->index();

        return $this->success(
            'Business accounts retrieved successfully',
            BusinessAccountResource::collection($accounts),
            200
        );
    }

    public function store(StoreBusinessAccountRequest $request)
{
    Log::info("CONTROLLER REACHED");

    $businessAccount = $this->service->store($request->validated());

    Log::info("AFTER SERVICE");

    app(\App\Http\Controllers\FcmController::class)->notifyAdmins(
        __('notifications.business_account_new_title'),
        __('notifications.business_account_new_body'),
        'new_business_account',
        ['business_id' => $businessAccount->id]
    );

    Log::info("NOTIFICATION SENT");

    return $this->success(
        'Business account created successfully',
        new BusinessAccountResource($businessAccount),
        201
    );
}

    public function show($id)
    {
        $account = $this->service->show($id);

        return $this->success(
            'Business account retrieved successfully',
            new BusinessAccountResource($account),
            200
        );
    }

    public function update(UpdateBusinessAccountRequest $request, $id)
    {
        $businessAccount = $this->service->update($id, $request->validated());

        return $this->success(
            'Business account updated successfully',
            new BusinessAccountResource($businessAccount),
            200
        );
    }

    public function destroy($id)
    {
        $this->service->destroy($id);

        return $this->success(
            'Business account deleted successfully',
            null,
            200
        );
    }
public function restore($id)
{
    $restored = $this->service->restore($id);

    if (!$restored) {
        return $this->error('Business account not found or not deleted', 404);
    }

    return $this->success('Business account restored successfully');
}


}
