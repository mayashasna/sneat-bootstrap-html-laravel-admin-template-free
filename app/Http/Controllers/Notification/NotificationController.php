<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * عرض إشعارات المستخدم الحالي
     */
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id', auth('api')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'message' => __('messages.notifications_fetched'),
            'data'    => $notifications
        ]);
    }
}
