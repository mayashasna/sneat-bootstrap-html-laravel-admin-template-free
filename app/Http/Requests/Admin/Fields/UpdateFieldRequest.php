<?php

namespace App\Http\Requests\Admin\Fields;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            // الحقول الجديدة الخاصة بالمورف
            'dynamic_fieldable_type' => 'required|string|in:App\Models\Category,App\Models\Subcategory',
            'dynamic_fieldable_id'   => 'required|integer',

            // أسماء الحقول
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',

            // نوع الحقل
            'type' => 'required|string|in:text,number,select,checkbox,radio,date',

            // خيارات Boolean
            'is_required'   => 'nullable|boolean',
            'is_filterable' => 'nullable|boolean',
            'is_active'     => 'nullable|boolean',

            // الترتيب
        ];
    }
}
