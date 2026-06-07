<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SliderImage;
use App\Models\BusinessAccount;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ============================
        // 1) جلب صور السلايدر
        // ============================
        $images = SliderImage::orderBy('created_at', 'desc')->get()->map(function ($img) {
            $isExpired = $img->created_at < now()->subDay();

            return [
                'path' => $img->path,
                'expired' => $isExpired,
                'created_at' => $img->created_at
            ];
        });

        // ============================
        // 2) جلب عدد حسابات الأعمال لكل شهر
        // ============================
        $businessAccounts = BusinessAccount::selectRaw('COUNT(*) as total, MONTH(created_at) as month')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $businessAccountsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $businessAccountsData[] = $businessAccounts[$i] ?? 0;
        }

        // ============================
        // 3) المدن الأكثر نشاطاً (Pie Chart)
        // ============================
        $citiesStats = BusinessAccount::with('city')
            ->selectRaw('city_id, COUNT(*) as total')
            ->groupBy('city_id')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        // أسماء المدن (من جدول City)
        $cities = $citiesStats->map(fn($item) => $item->city?->name_ar ?? 'غير معروف');

        // عدد الحسابات بكل مدينة
        $citiesCounts = $citiesStats->pluck('total');

        // ============================
        // 4) إرسال البيانات للواجهة
        // ============================
        return view('admin.dashboard.index', [
            'rolesCount' => \Spatie\Permission\Models\Role::count(),
            'adminsCount' => \App\Models\Admin::count(),
            'businessAccountsTotal' => BusinessAccount::count(),
            'images' => $images,

            // بيانات مخطط حسابات الأعمال
            'businessAccountsData' => $businessAccountsData,
            'months' => $months,

            // بيانات مخطط المدن
            'cities' => $cities,
            'citiesCounts' => $citiesCounts,
        ]);
    }
}
