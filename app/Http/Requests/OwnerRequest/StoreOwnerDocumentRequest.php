<?php

namespace App\Http\Requests\OwnerRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreOwnerDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    public function rules(): array
    {
        return [
            'national_id' => [
                'required',
                'string',
                'max:50',
            ],

            'issue_city_id' => [
                'required',
                'integer',
                'exists:cities,id',
            ],

            'issue_date' => [
                'required',
                'date',
            ],

            'expiry_date' => [
                'required',
                'date',
                'after:issue_date',
            ],

            'id_card_image_url' => [
                'required',
                'string',
                'url',
            ],
        ];
    }
}