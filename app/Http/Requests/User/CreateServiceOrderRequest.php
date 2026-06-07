<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // سنعتمد التحقق داخل الـ Service Layer
    }

    public function rules(): array
    {
        return [
            'service_id' => 'required|exists:services,id',
            'business_id' => 'required|exists:business_accounts,id', // الحساب الطالب
            'quantity' => 'required|integer|min:1',
            'needed_at' => 'nullable|date',
            'details' => 'nullable|string|max:2000',
        ];
    }
}
