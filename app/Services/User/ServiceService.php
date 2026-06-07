<?php

namespace App\Services\User;

use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ServiceService
{
    // عرض خدمات المستخدم
    public function listForUser()
    {
        $user = auth('api')->user();
        $businessIds = $user->businessAccounts()->pluck('id');

        return Service::whereIn('business_id', $businessIds)
            ->with(['media', 'fieldValues.field'])
            ->latest()
            ->paginate(10);
    }

    // عرض خدمة واحدة للمستخدم
    public function showForUser($id)
    {
        $user = auth('api')->user();
        $businessIds = $user->businessAccounts()->pluck('id');

        return Service::where('id', $id)
            ->whereIn('business_id', $businessIds)
            ->with(['media', 'fieldValues.field'])
            ->first();
    }

    // إنشاء خدمة
    public function create($request): Service
    {
        $data = $request->validated();

        return DB::transaction(function () use ($data, $request) {

            $service = Service::create([
                'business_id'     => $data['business_id'],
                'category_id'     => $data['category_id'],
                'subcategory_id'  => $data['subcategory_id'] ?? null,
                'title_ar'        => $data['title_ar'],
                'title_en'        => $data['title_en'],
                'description_ar'  => $data['description_ar'],
                'description_en'  => $data['description_en'],
                'quantity'        => $data['quantity'],
                'type'            => $data['type'] ?? null,
                'price_usd'       => $data['price_usd'],
                'price_syp'       => $data['price_syp'],
                'location_text'   => $data['location_text'] ?? null,
                'latitude'        => $data['latitude'] ?? null,
                'longitude'       => $data['longitude'] ?? null,
                'status'          => 'Pending',
            ]);

            // الصورة الرئيسية
            if ($request->hasFile('main_image')) {
                $service->addMedia($request->file('main_image'))
                        ->toMediaCollection('main_image');
            }

            // معرض الصور
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $service->addMedia($file)->toMediaCollection('gallery');
                }
            }

            // الحقول الديناميكية
            if (!empty($data['dynamic_fields'])) {
                foreach ($data['dynamic_fields'] as $fieldId => $value) {
                    $service->fieldValues()->create([
                        'field_id' => $fieldId,
                        'value'    => is_array($value) ? json_encode($value) : $value,
                    ]);
                }
            }

            return $service->load('media', 'fieldValues.field');
        });
    }

    // تعديل خدمة
    public function update(Service $service, $request): Service
    {
        $data = $request->validated();

        return DB::transaction(function () use ($service, $data, $request) {

            $service->update([
                'category_id'     => $data['category_id'],
                'subcategory_id'  => $data['subcategory_id'] ?? null,
                'title_ar'        => $data['title_ar'],
                'title_en'        => $data['title_en'],
                'description_ar'  => $data['description_ar'],
                'description_en'  => $data['description_en'],
                'quantity'        => $data['quantity'],
                'type'            => $data['type'] ?? null,
                'price_usd'       => $data['price_usd'],
                'price_syp'       => $data['price_syp'],
                'location_text'   => $data['location_text'] ?? null,
                'latitude'        => $data['latitude'] ?? null,
                'longitude'       => $data['longitude'] ?? null,
                'status'          => 'Pending',
            ]);

            // تحديث الصورة الرئيسية
            if ($request->hasFile('main_image')) {
                $service->clearMediaCollection('main_image');
                $service->addMedia($request->file('main_image'))
                        ->toMediaCollection('main_image');
            }

            // تحديث معرض الصور
            if ($request->hasFile('gallery')) {
                $service->clearMediaCollection('gallery');
                foreach ($request->file('gallery') as $file) {
                    $service->addMedia($file)->toMediaCollection('gallery');
                }
            }

            // حذف القيم القديمة
            $service->fieldValues()->delete();

            // حفظ القيم الجديدة
            if (!empty($data['dynamic_fields'])) {
                foreach ($data['dynamic_fields'] as $fieldId => $value) {
                    $service->fieldValues()->create([
                        'field_id' => $fieldId,
                        'value'    => is_array($value) ? json_encode($value) : $value,
                    ]);
                }
            }

            return $service->load('media', 'fieldValues.field');
        });
    }

    // حذف (Soft Delete)
    public function delete(Service $service)
    {
        return $service->delete();
    }

    // عرض الخدمات المحذوفة
    public function trashed()
    {
        $user = auth('api')->user();
        $businessIds = $user->businessAccounts()->pluck('id');

        return Service::onlyTrashed()
            ->whereIn('business_id', $businessIds)
            ->with(['media', 'fieldValues.field'])
            ->get();
    }

    // استرجاع خدمة
    public function restore($id)
{
    $service = Service::onlyTrashed()->findOrFail($id);
    return $service->restore();
}

    // فلترة الخدمات
    public function filterServices($filters)
    {
        $query = Service::query();

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['subcategory_id'])) {
            $query->where('subcategory_id', $filters['subcategory_id']);
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price_usd', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price_usd', '<=', $filters['max_price']);
        }

        if (!empty($filters['location_text'])) {
            $query->where('location_text', 'LIKE', '%' . $filters['location_text'] . '%');
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title_ar', 'LIKE', '%' . $filters['search'] . '%')
                  ->orWhere('title_en', 'LIKE', '%' . $filters['search'] . '%');
            });
        }

        return $query->with(['media', 'fieldValues.field'])->paginate(10);
    }
}
