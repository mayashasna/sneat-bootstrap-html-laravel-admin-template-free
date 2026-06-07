<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessAccountResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'name_ar'         => $this->name_ar,
            'name_en'         => $this->name_en,
            'details'         => $this->details,
            'status'          => $this->status,

            'activity_type' => [
                'id'   => $this->activityType?->id,
                'name' => $this->activityType?->name,
            ],

            'city' => [
                'id'   => $this->city?->id,
                'name' => $this->city?->name,
            ],

            'location' => [
                'latitude'  => $this->latitude,
                'longitude' => $this->longitude,
            ],

            'documents' => $this->documents
                ? collect($this->documents)->map(function ($doc) {
                    return [
                        'id'  => $doc['id'] ?? null,
                        'url' => $doc['url'] ?? null,
                    ];
                })
                : [],

            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
