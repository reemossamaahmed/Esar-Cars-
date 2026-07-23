<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'email' => [
                'required',
                'email',
            ],


            'otp' => [
                'required',
                'digits:6',
            ],


            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

        ];
    }


    public function messages(): array
    {
        return [

            'email.required' =>
                __('validation.email_required'),

            'email.email' =>
                __('validation.email_invalid'),

            'otp.required' =>
                __('validation.otp_required'),

            'password.required' =>
                __('validation.password_required'),

            'password.min' =>
                __('validation.password_min'),

            'password.confirmed' =>
                __('validation.password_confirmed'),

        ];
    }
}
