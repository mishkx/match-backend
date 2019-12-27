<?php

namespace App\Http\Requests\Auth;

use App\Constants\UserConstants;
use Illuminate\Foundation\Http\FormRequest;

class SavePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password' => ['required', 'string', 'min:' . UserConstants::MIN_PASSWORD_LENGTH, 'confirmed'],
        ];
    }
}
