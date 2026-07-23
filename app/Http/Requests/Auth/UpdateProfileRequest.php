<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name'=>[
                'sometimes',
                'string',
                'max:255'
            ],

            'phone'=>[
                'sometimes',
                'string',
                'max:20'
            ],

            'city'=>[
                'sometimes',
                'string',
                'max:100'
            ],

            'avatar' => [
                'sometimes',
                'url',
            ],

        ];
    }
}
