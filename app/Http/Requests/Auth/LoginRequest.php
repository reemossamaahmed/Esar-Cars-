<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'=>[
                'required',
                'email'
            ],


            'password'=>[
                'required',
                'string'
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'email.required'=>__('auth.email_required'),

            'email.email'=>__('auth.email_invalid'),

            'password.required'=>__('auth.password_required'),

        ];
    }
}
