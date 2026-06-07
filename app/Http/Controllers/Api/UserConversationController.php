<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Conversation\ConversationService;
use Illuminate\Http\Request;

class UserConversationController extends Controller
{
    protected $conversationService;

    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    public function start(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $conversation = $this->conversationService->startConversation(
            auth()->user(),
            $request->service_id
        );

        return response()->json([
            'status' => true,
            'message' => 'Conversation started successfully',
            'data' => $conversation
        ]);
    }
}
