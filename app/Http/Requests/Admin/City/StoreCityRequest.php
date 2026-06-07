<?php

namespace App\Http\Requests\Admin\City;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // لاحقاً ممكن نربطها بصلاحيات
    }

    public function rules(): array
    {
        return [
            'name_ar'   => 'required|string|max:255',
            'name_en'   => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ];
    }
}
