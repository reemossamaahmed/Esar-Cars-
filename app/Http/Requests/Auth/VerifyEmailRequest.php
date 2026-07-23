<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
            ],

            'otp' => [
                'required',
                'digits:6',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'email.required' => __('validation.email_required'),

            'email.email' => __('validation.email_invalid'),

            'otp.required' => __('validation.otp_required'),

            'otp.digits' => __('validation.otp_digits'),

        ];
    }
}
