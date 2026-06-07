<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\ServiceFavoriteService;
use Illuminate\Http\Request;

class ServiceFavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(ServiceFavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * إضافة/إزالة خدمة من المفضلة
     */
    public function toggle(Request $request, $serviceId)
    {
        $user = $request->user();
        $service = Service::findOrFail($serviceId);

        $isFavorite = $this->favoriteService->toggleFavorite($user, $service);

        return response()->json([
            'status' => true,
            'is_favorite' => $isFavorite,
            'message' => $isFavorite
                ? 'Service added to favorites'
                : 'Service removed from favorites',
        ]);
    }

    /**
     * جلب قائمة المفضلة
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $favorites = $this->favoriteService->getUserFavorites($user);

        return response()->json([
            'status' => true,
            'data' => $favorites,
        ]);
    }
}
