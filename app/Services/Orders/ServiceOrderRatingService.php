<?php

namespace App\Services\Orders;

use App\Models\ServiceOrder;
use App\Models\ServiceOrderRating;

class ServiceOrderRatingService
{
    public function rate(array $data)
    {
        // 1) جلب الطلب
        $order = ServiceOrder::findOrFail($data['order_id']);

        // 2) التحقق أن اللي عم يقيّم هو requester
        if ($order->requester_business_id != $data['requester_business_id']) {
            abort(403, __('messages.not_allowed_to_rate'));
        }

        // 3) التحقق أن الطلب مقبول
        if ($order->status !== 'accepted') {
            abort(403, __('messages.order_not_accepted'));
        }

        // 4) منع التقييم المكرر
        $existing = ServiceOrderRating::where('order_id', $order->id)->first();
        if ($existing) {
            abort(403, __('messages.order_already_rated'));
        }

        // 5) إنشاء التقييم
        return ServiceOrderRating::create([
            'order_id' => $order->id,
            'requester_business_id' => $order->requester_business_id,
            'provider_business_id' => $order->provider_business_id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);
    }
}
