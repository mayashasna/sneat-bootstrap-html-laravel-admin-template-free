<?php

namespace App\Http\Controllers;

use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FcmController extends Controller
{
    /**
     * تخزين توكن المتصفح
     */
    public function storeToken(Request $request)
    {
        $request->validate([
            'fcm_token'   => 'required|string',
            'device_type' => 'nullable|string',
        ]);

        $user = auth('admin')->user() ?? auth()->user();
        $userId = $user ? $user->id : null;

        try {
            $existing = DeviceToken::where('fcm_token', $request->fcm_token)->first();

            if (!$existing) {
                DeviceToken::create([
                    'user_id'     => $userId,
                    'fcm_token'   => $request->fcm_token,
                    'device_type' => $request->device_type ?? 'web',
                ]);
            }

            return response()->json(['message' => 'Token stored successfully']);
        } catch (\Exception $e) {
            Log::error('storeToken error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to store token'], 500);
        }
    }

    /**
     * إرسال إشعار لمستخدم معيّن (خاص بالموبايل)
     */
    public function sendNotification(Request $request)
    {
        Log::info("sendNotification CALLED");

        $request->validate([
            'user_id' => 'required|integer',
            'title'   => 'required|string',
            'body'    => 'required|string',
        ]);

        try {
            $messaging = app('firebase.messaging');

            $tokens = DeviceToken::where('user_id', $request->user_id)
                ->pluck('fcm_token')
                ->toArray();

            Log::info("TOKENS: " . json_encode($tokens));

            if (empty($tokens)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tokens found for this user'
                ]);
            }

            // هذا الإرسال خاص بالموبايل فقط
            $message = CloudMessage::new()
                ->withNotification(Notification::create($request->title, $request->body))
                ->withData([
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
                ]);

            $report = $messaging->sendMulticast($message, $tokens);

            if ($report->hasFailures()) {
                foreach ($report->failures()->getItems() as $failure) {
                    $failedToken = $failure->target()->value();
                    DeviceToken::where('fcm_token', $failedToken)->delete();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Notification sent',
                'report'  => [
                    'successes' => $report->successes()->count(),
                    'failures'  => $report->failures()->count(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error("FCM Error: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * إرسال إشعار لكل المدراء (Web Push)
     */
    public function sendToAdmins($title, $body)
    {
        try {
            Log::info("sendToAdmins CALLED");

            $messaging = app('firebase.messaging');

            $tokens = DeviceToken::where('device_type', 'admin')
                ->pluck('fcm_token')
                ->toArray();

            Log::info("ADMIN TOKENS: " . json_encode($tokens));

            if (empty($tokens)) {
                Log::info("NO ADMIN TOKENS FOUND");
                return;
            }

            // 🔥 WebPush ONLY — صيغة صحيحة 100%
            $message = CloudMessage::new()
                ->withWebPushConfig([
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                        'icon'  => '/logo.png',
                    ],
                    'fcm_options' => [
                        'link' => 'https://localhost'
                    ],
                    'headers' => [
                        'TTL' => '4500',
                        'Urgency' => 'high'
                    ]
                ]);

            $messaging->sendMulticast($message, $tokens);

            Log::info("ADMIN NOTIFICATION SENT");
        } catch (\Exception $e) {
            Log::error("FCM Error: " . $e->getMessage());
        }
    }
    /**
 * إشعار موحّد للأدمن: يخزّن بالـ DB + يبعت push
 */
public function notifyAdmins($title, $body, $type = null, $data = null)
{
    // 1) خزّن الإشعار بقاعدة البيانات (للصفحة)
    \App\Models\AdminNotification::create([
        'title'   => $title,
        'body'    => $body,
        'type'    => $type,
        'data'    => $data,
        'is_read' => false,
    ]);

    // 2) ابعت push للمدراء (الدالة الموجودة)
    $this->sendToAdmins($title, $body);
}
}
