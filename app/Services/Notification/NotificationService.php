<?php

namespace App\Services\Notification;

use App\Models\Notification;

class NotificationService
{
    /**
     * إنشاء إشعار لمستخدم معين باستخدام مفاتيح الترجمة
     */
    public function notifyUser($userId, $titleKey, $bodyKey, $data = [], $type = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title'   => __($titleKey),
            'body'    => __($bodyKey),
            'type'    => $type,
            'data'    => $data,
            'is_read' => false,
        ]);
    }
}
