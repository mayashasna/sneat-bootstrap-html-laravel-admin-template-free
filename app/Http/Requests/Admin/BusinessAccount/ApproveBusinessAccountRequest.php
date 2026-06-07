<?php

namespace App\Http\Requests\Admin\BusinessAccount;

use Illuminate\Foundation\Http\FormRequest;

class ApproveBusinessAccountRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('approve-business');
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:business_accounts,id',
        ];
    }
}
