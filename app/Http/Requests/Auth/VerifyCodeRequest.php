<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class VerifyCodeRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'phone:AUTO'],
            'otp' => 'required|numeric|digits:6',
        ];
    }
}
