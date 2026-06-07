<?php

namespace App\Services\Admin;

use App\Models\Service;

class ServiceService
{
    // عرض خدمة واحدة مع كل التفاصيل
    public function show($id)
    {
        $service = Service::with(['media', 'fieldValues.field'])
            ->findOrFail($id);

        return [
            'id'             => $service->id,
            'business_id'    => $service->business_id,
            'category_id'    => $service->category_id,
            'subcategory_id' => $service->subcategory_id,
            'title_ar'       => $service->title_ar,
            'title_en'       => $service->title_en,
            'description_ar' => $service->description_ar,
            'description_en' => $service->description_en,
            'quantity'       => $service->quantity,
            'type'           => $service->type,
            'price_usd'      => $service->price_usd,
            'price_syp'      => $service->price_syp,
            'location_text'  => $service->location_text,
            'latitude'       => $service->latitude,
            'longitude'      => $service->longitude,
            'status'         => $service->status,
            'is_active'      => $service->is_active,

            'main_image'     => $service->getFirstMediaUrl('main_image'),
            'gallery'        => $service->getMedia('gallery')->map->getUrl(),

            'fields'         => $service->fieldValues()->get(['field_id','value']),
            'created_at'     => $service->created_at->toDateTimeString(),
            'updated_at'     => $service->updated_at->toDateTimeString(),
        ];
    }

    // الموافقة على الخدمة
    public function approve($id): bool
    {
        return Service::findOrFail($id)->update(['status' => 'Approved']);
    }

    // رفض الخدمة
    public function reject($id): bool
    {
        return Service::findOrFail($id)->update(['status' => 'Rejected']);
    }

    // تفعيل/إلغاء تفعيل الخدمة
    public function toggleStatus($id)
    {
        $service = Service::findOrFail($id);

        $service->is_active = !$service->is_active;
        $service->save();

        return $service;
    }

    // عرض الخدمات المحذوفة
    public function trashed()
    {
        return Service::onlyTrashed()
            ->with(['media', 'fieldValues.field'])
            ->paginate(10);
    }

    // استرجاع خدمة محذوفة
    public function restore($id)
    {
        $service = Service::onlyTrashed()->findOrFail($id);
        return $service->restore();
    }
}
