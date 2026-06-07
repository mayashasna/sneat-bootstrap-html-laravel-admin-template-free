<?php

namespace App\Http\Requests\Admin\Fields;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFieldOptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value_ar'   => 'required|string|max:255',
            'value_en'   => 'required|string|max:255',
            'is_active'  => 'nullable|boolean',
        ];
    }
}
