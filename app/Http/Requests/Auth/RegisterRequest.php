<?php

namespace App\Http\Requests\Auth;

use App\Constants\UserConstants;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:' . UserConstants::MIN_PASSWORD_LENGTH, 'confirmed'],
            'remember' => ['accepted'],
        ];
    }
}
