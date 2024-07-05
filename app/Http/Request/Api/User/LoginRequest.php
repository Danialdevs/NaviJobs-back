<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => ['required|string'],
            'password' => ['required'],
            'phone_number' => ['required|integer', 'digits:11'],
        ];
    }
}
