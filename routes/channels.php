<?php

use Illuminate\Support\Facades\Broadcast;

use App\Models\Conversation;

Broadcast::channel('conversation.{id}', function ($user, $id) {
    return true; // مؤقتاً للاختبار — لاحقاً تحقق إنه المستخدم طرف بالمحادثة
});

