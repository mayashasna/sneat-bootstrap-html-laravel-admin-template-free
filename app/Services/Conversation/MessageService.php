<?php

namespace App\Services\Conversation;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;

class MessageService
{
    public function sendMessage($authUser, $conversationId, $body)
    {
        // 1) جلب المحادثة
        $conversation = Conversation::findOrFail($conversationId);

        // 2) تحقق أن المستخدم مشارك بالمحادثة
        $isParticipant = $conversation->participants()
            ->where('user_id', $authUser->id)
            ->exists();

        if (! $isParticipant) {
            throw new \Exception("You are not a participant in this conversation.");
        }

        // 3) إنشاء الرسالة
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $authUser->id,
            'body'            => $body,
            'status'          => 'sent',
        ]);

        // 4) تحميل المرسل
        $message->load('sender');

        // 5) بث الحدث
        event(new MessageSent($message));

        return $message;
    }
    public function markAsRead($authUser, $conversationId)
{
    // 1) جلب المحادثة
    $conversation = Conversation::findOrFail($conversationId);

    // 2) تحقق أن المستخدم مشارك بالمحادثة
    $isParticipant = $conversation->participants()
        ->where('user_id', $authUser->id)
        ->exists();

    if (! $isParticipant) {
        throw new \Exception("You are not a participant in this conversation.");
    }

    // 3) تحديث الرسائل غير المقروءة (اللي مو مرسلة من المستخدم)
    Message::where('conversation_id', $conversationId)
        ->where('sender_id', '!=', $authUser->id)
        ->whereNull('read_at')
        ->update([
            'status'  => 'read',
            'read_at' => now(),
        ]);

    return true;
}



}
