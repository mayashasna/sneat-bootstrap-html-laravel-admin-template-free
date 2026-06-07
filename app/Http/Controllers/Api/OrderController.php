<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateServiceOrderRequest;
use App\Services\Orders\ServiceOrderService;

class OrderController extends Controller
{
    public function __construct(private ServiceOrderService $service) {}

    public function store(CreateServiceOrderRequest $request)
    {
        $order = $this->service->create($request->validated());

        return response()->json([
            'message' => __('messages.order_created'),
            'data' => $order
        ], 201);
    }

    public function sent()
    {
        $businessId = request()->business_id;

        $orders = $this->service->getSentOrders($businessId);

        return response()->json([
            'message' => __('messages.sent_orders'),
            'data' => $orders
        ]);
    }

    public function received()
    {
        $businessId = request()->business_id;

        $orders = $this->service->getReceivedOrders($businessId);

        return response()->json([
            'message' => __('messages.received_orders'),
            'data' => $orders
        ]);
    }

    public function accept($id)
    {
        $providerBusinessId = request()->business_id;

        $order = $this->service->accept($id, $providerBusinessId);

        return response()->json([
            'message' => __('messages.order_accepted'),
            'data' => $order
        ]);
    }

public function reject($id)
{
    $providerBusinessId = request()->business_id;

    $order = $this->service->reject($id, $providerBusinessId, request()->all());

    return response()->json([
        'message' => __('messages.order_rejected'),
        'data' => $order
    ]);
}

}
