<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ConversationService;

class ConversationController extends Controller
{
    public function __construct(
        protected ConversationService $conversationService
    ) {}

    /**
     * عرض قائمة المحادثات في لوحة التحكم
     */
    public function index()
    {
        $conversations = $this->conversationService->getConversationsForAdmin();

        return view('conversations.index', compact('conversations'));
    }

    /**
     * عرض تفاصيل محادثة معيّنة
     */
    public function show(int $id)
    {
        $conversation = $this->conversationService->getConversationDetailsForAdmin($id);

        return view('conversations.show', compact('conversation'));
    }
}
