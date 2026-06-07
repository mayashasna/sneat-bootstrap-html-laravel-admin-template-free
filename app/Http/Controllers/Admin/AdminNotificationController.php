<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;

class AdminNotificationController extends Controller
{
    // صفحة عرض كل الإشعارات
    public function index()
    {
        $notifications = AdminNotification::latest()->paginate(15);
        $unreadCount   = AdminNotification::where('is_read', false)->count();

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    // تحديد إشعار واحد كمقروء
    public function markAsRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return back();
    }

    // تحديد الكل كمقروء
    public function markAllAsRead()
    {
        AdminNotification::where('is_read', false)->update(['is_read' => true]);

        return back();
    }
}
