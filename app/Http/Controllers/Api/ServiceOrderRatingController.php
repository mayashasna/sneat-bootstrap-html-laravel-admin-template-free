<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Orders\ServiceOrderRatingService;
use Illuminate\Http\Request;

class ServiceOrderRatingController extends Controller
{
    public function __construct(private ServiceOrderRatingService $service) {}

    public function rate(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|integer',
            'requester_business_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $rating = $this->service->rate($data);

        return response()->json([
            'message' => __('messages.order_rated_successfully'),
            'data' => $rating
        ]);
    }
}
