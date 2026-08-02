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

        ];
    }



    public function messages(): array
    {
        return [

            'policy_text.required' =>
                __('car.policy_text_required'),


            'days_before.required' =>
                __('car.days_before_required'),


            'days_before.integer' =>
                __('car.days_before_integer'),

        ];
    }

}
