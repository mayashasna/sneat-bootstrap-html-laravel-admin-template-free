<?php

namespace App\Services\Conversation;

use App\Models\Conversation;
use App\Models\Service;

class ConversationService
{
    public function startConversation($authUser, $serviceId)
{
    $service = Service::with(['business.user'])->findOrFail($serviceId);

    if (! $service->business) {
        throw new \Exception("Service has no business account.");
    }

    $provider = $service->business->user;

    if (! $provider) {
        throw new \Exception("Business account has no owner user.");
    }

    if ($authUser->id === $provider->id) {
        throw new \Exception("You cannot start a conversation with yourself.");
    }

    // هل توجد محادثة سابقة؟
    $conversation = Conversation::where('service_id', $service->id)
        ->whereHas('participants', fn($q) => $q->where('user_id', $authUser->id))
        ->whereHas('participants', fn($q) => $q->where('user_id', $provider->id))
        ->first();

    if (! $conversation) {
        $conversation = Conversation::create([
            'service_id' => $service->id,
        ]);

        // attach بشكل صحيح
        $conversation->participants()->attach($authUser->id);
        $conversation->participants()->attach($provider->id);
    }

    return $conversation->load(['participants', 'service']);
}

}
