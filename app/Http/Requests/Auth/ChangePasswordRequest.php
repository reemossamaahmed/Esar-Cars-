<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:current_password'
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'current_password.required' =>
                __('validation.current_password_required'),


            'password.required' =>
                __('validation.password_required'),


            'password.min' =>
                __('validation.password_min'),


            'password.confirmed' =>
                __('validation.password_confirmed'),


            'password.different' =>
                __('validation.password_different'),

        ];
    }
}
