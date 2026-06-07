<?php

namespace App\Services\Orders;

use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\BusinessAccount;
use App\Services\Notification\NotificationService;

class ServiceOrderService
{
    public function create(array $data): ServiceOrder
    {
        $service = Service::findOrFail($data['service_id']);

        // منع صاحب الخدمة من طلب خدمته
        if ($service->business_id == $data['business_id']) {
            abort(403, __('messages.cannot_order_own_service'));
        }

        // التحقق من حساب الأعمال للزبون
        $requester = BusinessAccount::findOrFail($data['business_id']);

        if ($requester->status !== 'Approved') {
            abort(403, __('messages.business_not_approved'));
        }

        // التحقق من توفر الكمية
        if ($service->quantity < $data['quantity']) {
            abort(403, __('messages.not_enough_quantity'));
        }

        // إنشاء الطلب
        $order = ServiceOrder::create([
            'service_id' => $service->id,
            'requester_business_id' => $requester->id,
            'provider_business_id' => $service->business_id,
            'quantity' => $data['quantity'],
            'needed_at' => $data['needed_at'] ?? null,
            'details' => $data['details'] ?? null,
            'status' => 'pending',
        ]);

        // إنقاص الكمية من الخدمة
        $service->update([
            'quantity' => $service->quantity - $data['quantity']
        ]);

        // 🔥 إشعار DB لصاحب الخدمة
        app(NotificationService::class)->notifyUser(
            $service->business->user_id,
            'notifications.new_order_title',
            'notifications.new_order_body',
            [
                'order_id' => $order->id,
                'service_id' => $service->id,
                'quantity' => $order->quantity,
            ],
            'new_order'
        );

        // 🔥 إشعار FCM لكل المدراء
        app(\App\Http\Controllers\FcmController::class)
            ->sendToAdmins(
                "طلب جديد",
                "تم إنشاء طلب جديد على الخدمة: " . $service->title_ar
            );

        return $order;
    }



    public function getSentOrders(int $businessId)
    {
        return ServiceOrder::with([
            'service',
            'providerBusiness',
            'requesterBusiness'
        ])
        ->where('requester_business_id', $businessId)
        ->orderBy('id', 'desc')
        ->get();
    }

    public function getReceivedOrders(int $businessId)
    {
        return ServiceOrder::with([
            'service',
            'requesterBusiness',
            'providerBusiness'
        ])
        ->where('provider_business_id', $businessId)
        ->orderBy('id', 'desc')
        ->get();
    }



    public function accept(int $orderId, int $providerBusinessId): ServiceOrder
    {
        $order = ServiceOrder::where('id', $orderId)
            ->where('provider_business_id', $providerBusinessId)
            ->firstOrFail();

        if ($order->status !== 'pending') {
            abort(403, __('messages.order_not_pending'));
        }

        // تغيير حالة الطلب
        $order->update([
            'status' => 'accepted'
        ]);

        // 🔥 إشعار DB للزبون
        app(NotificationService::class)->notifyUser(
            $order->requesterBusiness->user_id,
            'notifications.order_accepted_title',
            'notifications.order_accepted_body',
            [
                'order_id' => $order->id,
                'service_id' => $order->service_id,
                'provider_business_id' => $order->provider_business_id,
            ],
            'order_accepted'
        );

        // 🔥 إشعار FCM للزبون
        app(\App\Http\Controllers\FcmController::class)
            ->sendNotification(new \Illuminate\Http\Request([
                'user_id' => $order->requesterBusiness->user_id,
                'title'   => "تم قبول طلبك",
                'body'    => "تم قبول طلبك على الخدمة: " . $order->service->title_ar,
            ]));

        return $order;
    }



    public function reject(int $orderId, int $providerBusinessId, array $data): ServiceOrder
    {
        $order = ServiceOrder::where('id', $orderId)
            ->where('provider_business_id', $providerBusinessId)
            ->firstOrFail();

        if ($order->status !== 'pending') {
            abort(403, __('messages.order_not_pending'));
        }

        // إرجاع الكمية للخدمة
        $service = Service::findOrFail($order->service_id);
        $service->update([
            'quantity' => $service->quantity + $order->quantity
        ]);

        // تحديث حالة الطلب + سبب الرفض
        $order->update([
            'status' => 'rejected',
            'reject_reason' => $data['reject_reason'] ?? null
        ]);

        // 🔥 إشعار DB للزبون
        app(NotificationService::class)->notifyUser(
            $order->requesterBusiness->user_id,
            'notifications.order_rejected_title',
            'notifications.order_rejected_body',
            [
                'order_id' => $order->id,
                'service_id' => $order->service_id,
                'provider_business_id' => $order->provider_business_id,
                'reject_reason' => $data['reject_reason'] ?? null
            ],
            'order_rejected'
        );

        // 🔥 إشعار FCM للزبون
        app(\App\Http\Controllers\FcmController::class)
            ->sendNotification(new \Illuminate\Http\Request([
                'user_id' => $order->requesterBusiness->user_id,
                'title'   => "تم رفض طلبك",
                'body'    => "تم رفض طلبك على الخدمة: " . $order->service->title_ar,
            ]));

        return $order;
    }
}
