<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreServiceRequest;
use App\Http\Requests\User\UpdateServiceRequest;
use App\Models\Service;
use App\Services\User\ServiceService;
use Illuminate\Http\Request;
use App\Http\Resources\ServiceResource; // ← أضفنا هذا

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    // عرض خدمات المستخدم فقط
    public function index()
    {
        $services = $this->serviceService->listForUser();

        // تحميل قيم الحقول الديناميكية مع كل خدمة
        $services->load('fieldValues.field');

        return response()->json([
            'message' => 'Services fetched successfully',
            'data'    => $services
        ]);
    }

    // عرض خدمة واحدة (بعد التعديل)
    public function show($id)
    {
        $service = $this->serviceService->showForUser($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        // تحميل قيم الحقول الديناميكية
        $service->load('fieldValues.field');

        // ← أهم تعديل: استخدام ServiceResource
        return new ServiceResource($service);
    }

    // إنشاء خدمة
    public function store(StoreServiceRequest $request)
    {
        $service = $this->serviceService->create($request);

        return response()->json([
            'message' => 'Service created successfully and pending approval',
            'data'    => $service
        ], 201);
    }

    // تعديل خدمة
    public function update(UpdateServiceRequest $request, $id)
    {
        $service = Service::whereIn('business_id', auth('api')->user()->businessAccounts->pluck('id'))
            ->where('id', $id)
            ->firstOrFail();

        $updated = $this->serviceService->update($service, $request);

        $updated->load('fieldValues.field');

        return response()->json([
            'message' => 'Service updated successfully',
            'data'    => $updated
        ]);
    }

    // حذف خدمة
    public function destroy($id)
    {
        $service = Service::whereIn('business_id', auth('api')->user()->businessAccounts->pluck('id'))
            ->where('id', $id)
            ->firstOrFail();

        $service->clearMediaCollection('main_image');
        $service->clearMediaCollection('gallery');

        $this->serviceService->delete($service);

        return response()->json(['message' => 'Service moved to trash successfully']);
    }

    // عرض الخدمات المحذوفة
    public function trashed()
    {
        $services = $this->serviceService->trashed();

        $services->load('fieldValues.field');

        return response()->json([
            'message' => 'Trashed services fetched successfully',
            'data'    => $services
        ]);
    }

    // استرجاع خدمة
    public function restore($id)
    {
        $this->serviceService->restore($id);

        return response()->json(['message' => 'Service restored successfully']);
    }

    // فلترة الخدمات
    public function filter(Request $request)
    {
        $filters = $request->only([
            'category_id',
            'subcategory_id',
            'type',
            'min_price',
            'max_price',
            'location_text',
            'search',
        ]);

        $services = $this->serviceService->filterServices($filters);

        $services->load('fieldValues.field');

        return response()->json([
            'message' => 'Services fetched successfully',
            'data'    => $services
        ]);
    }

    // طلب خدمة
    public function order($id)
    {
        $service = Service::findOrFail($id);

        if (!$service->is_active) {
            return response()->json([
                'message' => 'This service is not active',
            ], 403);
        }

        return response()->json([
            'message' => 'Service is active and can be ordered',
            'data' => [
                'id' => $service->id,
                'status' => 'active'
            ]
        ]);
    }
}
