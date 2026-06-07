<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize()
{
    $user = auth('api')->user();

    // Check if business account belongs to this user
    $business = $user->businessAccounts()->where('id', $this->business_id)->first();

    if (!$business) {
        abort(403, __('messages.business_not_owned'));
    }

    // Business is pending approval
    if ($business->status === 'Pending') {
        abort(403, __('messages.business_pending'));
    }

    // Business is rejected
    if ($business->status === 'Rejected') {
        abort(403, __('messages.business_rejected'));
    }

    return true;
}


    public function rules()
    {
        return [
            'business_id'      => 'required|exists:business_accounts,id',
            'category_id'      => 'required|exists:categories,id',
            'subcategory_id'   => 'nullable|exists:subcategories,id',

            'title_ar'         => 'required|string|max:255',
            'title_en'         => 'required|string|max:255',
            'description_ar'   => 'required|string',
            'description_en'   => 'required|string',

            'quantity'         => 'required|integer|min:1',
            'type'             => 'nullable|in:sale,rent',

            'price_usd'        => 'required|numeric|min:0',
            'price_syp'        => 'required|numeric|min:0',

            'location_text'    => 'nullable|string|max:255',
            'latitude'         => 'nullable|numeric',
            'longitude'        => 'nullable|numeric',

            'main_image'       => 'required|image|max:2048',
            'gallery.*'        => 'nullable|image|max:2048',

            // 🔥 الحقول الديناميكية الصحيحة
            'dynamic_fields'   => 'nullable|array',
            'dynamic_fields.*' => 'nullable',
        ];
    }
}
