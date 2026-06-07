<?php

namespace App\Http\Requests\Admin\Admins;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
{
    return [
        'name' => 'required|string',
        'email' => 'required|email|unique:admins,email',
        'password' => 'required|string|min:6',
        'status' => 'required|string',
        'roles' => 'required|array',
        'roles.*' => 'string|exists:roles,name',
    ];
}

}
