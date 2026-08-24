<?php

namespace App\Http\Requests\OwnerRequest;

use Illuminate\Foundation\Http\FormRequest;

class RejectOwnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rejection_reason' => [
                'required',
                'string',
                'min:5',
                'max:1000',
            ],
        ];
    }
}