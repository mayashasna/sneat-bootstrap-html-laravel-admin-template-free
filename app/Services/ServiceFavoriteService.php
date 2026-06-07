<?php

namespace App\Services;

use App\Models\Service;
use App\Models\User;

class ServiceFavoriteService
{
    /**
     * إضافة/إزالة خدمة من المفضلة
     */
    public function toggleFavorite(User $user, Service $service)
    {
        // toggle على pivot table
        $user->favoriteServices()->toggle($service->id);

        // هل الخدمة حالياً مفضلة؟
        return $user->favoriteServices()->where('service_id', $service->id)->exists();
    }

    /**
     * جلب قائمة المفضلة للمستخدم
     */
    public function getUserFavorites(User $user)
    {
        return $user->favoriteServices()
            ->with([
                'category',
                'subcategory',
                'business', // ✅ العلاقة الصحيحة بدل businessAccount
            ])
            ->get();
    }
}
