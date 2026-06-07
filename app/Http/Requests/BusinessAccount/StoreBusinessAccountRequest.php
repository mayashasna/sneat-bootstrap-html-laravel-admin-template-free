<?php

namespace App\Http\Requests\BusinessAccount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBusinessAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            // نوع النشاط — إلزامي + لا يمكن تكراره لنفس المستخدم
            'activity_type_id' => [
                'required',
                'exists:activity_types,id',
                Rule::unique('business_accounts', 'activity_type_id')
                    ->where(fn ($q) => $q->where('user_id', auth('api')->id())),
            ],

            // رقم الترخيص — إلزامي حسب نص المشروع
            'license_number' => ['required', 'string', 'max:255'],

            // أسماء العمل
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],

            // الأنشطة والتفاصيل
            'activities' => ['nullable', 'string', 'max:255'],
            'details' => ['nullable', 'string'],

            // المدينة — إلزامية
            'city_id' => ['required', 'exists:cities,id'],

            // الموقع الجغرافي — إلزامي
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],

            // المستندات — اختيارية
            'documents' => ['nullable', 'array'],
            'documents.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }
}
