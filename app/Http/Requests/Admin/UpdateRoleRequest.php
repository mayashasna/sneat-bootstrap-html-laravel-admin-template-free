<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        // فقط إذا عنده صلاحية تعديل الأدوار
        return $this->user()->can('update roles');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:roles,name,' . $this->route('role'),
            'display_name' => 'nullable|string',
        ];
    }
}
