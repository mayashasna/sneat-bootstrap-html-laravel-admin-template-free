<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    // عرض كل الخدمات
    public function index(Request $request)
    {
        $query = Service::with(['media', 'fieldValues.field'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by service type (sale / rent)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price_usd', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_usd', '<=', $request->max_price);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location_text', 'LIKE', '%' . $request->location . '%');
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by subcategory
        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        // Search by title (AR/EN)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title_ar', 'LIKE', "%$search%")
                  ->orWhere('title_en', 'LIKE', "%$search%");
            });
        }

        // ⭐ جلب التصنيفات
        $categories = \App\Models\Category::where('is_active', 1)->get();

        // ⭐ جلب التصنيفات الفرعية (بدون sort_order)
        $subcategories = \App\Models\Subcategory::where('is_active', 1)
            ->orderBy('id', 'desc')
            ->get();

        // Pagination
        $services = $query->paginate(10)->appends($request->query());

        return view('admin.services.index', compact('services', 'categories', 'subcategories'));
    }

    // عرض خدمة واحدة
    public function show($id)
    {
        $service = Service::with(['category', 'subcategory', 'media', 'fieldValues.field'])
            ->findOrFail($id);

        return view('admin.services.show', compact('service'));
    }

    // الموافقة على الخدمة
    public function approve($id)
    {
        $service = Service::findOrFail($id);
        $service->status = 'Approved';
        $service->save();

        return redirect()->route('admin.services.index')
                         ->with('success', 'Service approved successfully');
    }

    // رفض الخدمة
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:500'
        ]);

        $service = Service::findOrFail($id);
        $service->status = 'Rejected';
        $service->reject_reason = $request->reject_reason;
        $service->save();

        return redirect()->route('admin.services.index')
                         ->with('success', 'Service rejected successfully');
    }

    // تفعيل الخدمة
    public function activate($id)
    {
        $service = Service::findOrFail($id);
        $service->is_active = true;
        $service->save();

        return redirect()->back()->with('success', 'Service activated successfully');
    }

    // إلغاء التفعيل
    public function deactivate($id)
    {
        $service = Service::findOrFail($id);
        $service->is_active = false;
        $service->save();

        return redirect()->back()->with('success', 'Service deactivated successfully');
    }

    // عرض الخدمات المحذوفة
    public function trashed()
    {
        $services = Service::onlyTrashed()
            ->with(['media', 'fieldValues.field'])
            ->paginate(10);

        return view('admin.services.trashed', compact('services'));
    }

    // استرجاع خدمة محذوفة
    public function restore($id)
    {
        $service = Service::onlyTrashed()->findOrFail($id);
        $service->restore();

        return redirect()->back()->with('success', 'Service restored successfully');
    }

    public function map($id)
    {
        $service = Service::findOrFail($id);

        return view('admin.services.map', compact('service'));
    }
}
