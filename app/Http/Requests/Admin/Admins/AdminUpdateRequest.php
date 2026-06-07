<?php

namespace App\Http\Requests\Admin\Admins;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Laravel automatically injects the Admin model into the route
        // so $this->admin هو الـ Admin اللي عم نعدّله
        $adminId = $this->admin->id ?? null;

        return [
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:admins,email,' . $adminId,
            'status' => 'required|in:active,blocked',
'roles'   => 'required|array',
'roles.*' => 'string|exists:roles,name',

        ];
    }
}
