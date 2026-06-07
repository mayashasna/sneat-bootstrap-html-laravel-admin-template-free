<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
{
    return $this->user()->can('update roles');
}


    public function rules(): array
    {
        return [
'name' => 'required|unique:roles,name,' . $this->route('id'),
            'guard_name' => 'required|string|in:admin',
        ];
    }
}
