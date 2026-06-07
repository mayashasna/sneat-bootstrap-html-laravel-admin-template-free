<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Services\Conversation\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function send(Request $request, $conversationId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $authUser = $request->user();

        // إرسال الرسالة عبر السيرفس
        $message = $this->messageService->sendMessage(
            $authUser,
            $conversationId,
            $request->body
        );

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully',
            'data' => $message
        ]);
    }
public function markAsRead(Request $request, $conversationId)
{
    $authUser = $request->user();

    // 1) جلب المحادثة
    $conversation = Conversation::findOrFail($conversationId);

    // 2) تحقق أن المستخدم مشارك بالمحادثة
    $isParticipant = $conversation->participants()
        ->where('user_id', $authUser->id)
        ->exists();

    if (! $isParticipant) {
        throw new \Exception("You are not a participant in this conversation.");
    }

    // 3) تحديث الرسائل غير المقروءة
    Message::where('conversation_id', $conversationId)
        ->where('sender_id', '!=', $authUser->id)
        ->whereNull('read_at')
        ->update([
           
            'status'  => 'read',
            'read_at' => now(),
        ]);

    // 4) بث حدث القراءة
    event(new \App\Events\MessageRead($conversationId, $authUser->id));

    return response()->json(['status' => true]);
}
}
