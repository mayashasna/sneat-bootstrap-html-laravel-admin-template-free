<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   public function rules(): array
{
    return [
        'name_ar' => ['required', 'string', 'max:255'],
        'name_en' => ['required', 'string', 'max:255'],
        'is_active' => ['boolean'],
    ];
}

}
