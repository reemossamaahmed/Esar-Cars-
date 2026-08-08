<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCancellationPolicyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'policy_text' => [

                'sometimes',
                'string',
                'max:1000',

            ],


            'days_before' => [

                'sometimes',
                'integer',
                'min:0',

            ],

        ];
    }


    public function withValidator($validator)
    {

        $validator->after(function ($validator) {


            if ($this->all() === []) {


                $validator->errors()->add(

                    'update',

                    __('car.no_changes')

                );

            }


        });

    }


    public function messages(): array
    {
        return [

            'policy_text.string' =>
                __('car.policy_text_string'),


            'policy_text.max' =>
                __('car.policy_text_max'),


            'days_before.integer' =>
                __('car.days_before_integer'),


            'days_before.min' =>
                __('car.days_before_min'),

        ];
    }

}
