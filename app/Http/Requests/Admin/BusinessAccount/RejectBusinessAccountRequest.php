<?php

namespace App\Http\Requests\Admin\BusinessAccount;

use Illuminate\Foundation\Http\FormRequest;

class RejectBusinessAccountRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('reject-business');
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:business_accounts,id',
            'reason' => 'nullable|string|max:500'
        ];
    }
}
