<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarHandoverPolicyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            'pickup_method' => [
                'required',
                Rule::in([
                    'renter_pickup',
                    'owner_delivery',
                ]),
            ],

            'dropoff_method' => [
                'required',
                Rule::in([
                    'renter_return',
                    'owner_pickup',
                ]),
            ],

            'pickup_fee' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'dropoff_fee' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],

        ];
    }
}
