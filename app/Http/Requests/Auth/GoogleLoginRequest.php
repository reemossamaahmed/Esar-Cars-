<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class GoogleLoginRequest extends FormRequest
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
            'id_token' => [
                'required',
                'string'
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'id_token' => __('attributes.id_token'),
        ];
    }
}
