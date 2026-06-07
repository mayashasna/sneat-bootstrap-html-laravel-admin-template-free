<?php

namespace App\Services\Admin;

use App\Models\Conversation;

class ConversationService
{
    /**
     * جلب قائمة المحادثات للمدير
     */
    public function getConversationsForAdmin()
    {
        return Conversation::with([
            'service',
            'participants',
            'lastMessage'
        ])
        ->latest('updated_at')
        ->get();
    }

    /**
     * جلب تفاصيل محادثة معيّنة للمدير
     */
    public function getConversationDetailsForAdmin(int $conversationId)
    {
        return Conversation::with([
            'service',
            'participants',
            'messages.sender'
        ])
        ->findOrFail($conversationId);
    }
}
