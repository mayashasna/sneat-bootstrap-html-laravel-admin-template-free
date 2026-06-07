<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'price'         => $this->price,
            'currency'      => $this->currency,
            'type'          => $this->type,
            'quantity'      => $this->quantity,
            'status'        => $this->status,

            'main_image'    => $this->main_image,
            'images'        => $this->images,

            'category'      => [
                'id'    => $this->category?->id,
                'name'  => $this->category?->name,
            ],

            'subcategory'   => [
                'id'    => $this->subcategory?->id,
                'name'  => $this->subcategory?->name,
            ],

            'business_account' => [
                'id'    => $this->business?->id,
                'name'  => $this->business?->name_ar,
            ],

            // ⭐ أهم إضافة
            'is_favorite' => auth('api')->check()
                ? auth()->user()->favoriteServices()->where('service_id', $this->id)->exists()
                : false,
        ];
    }
}
