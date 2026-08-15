<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class StoreCancellationPolicyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'policy_text' => [
                'required',
                'string',
                'max:1000',
            ],


            'days_before' => [
                'required',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],

        ];
    }



    public function messages(): array
    {
        return [

            'policy_text.required' =>
                __('car.policy_text_required'),


            'policy_text.string' =>
                __('car.policy_text_string'),


            'policy_text.max' =>
                __('car.policy_text_max'),


            'days_before.required' =>
                __('car.days_before_required'),


            'days_before.integer' =>
                __('car.days_before_integer'),


            'days_before.min' =>
                __('car.days_before_min'),

            'is_active.boolean' =>
                __('car.is_active_boolean'),

        ];
    }

}
