<?php

namespace App\Http\Requests\Car;

use App\Enums\CustomPriceReason;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomPriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'date_from' => [
                'sometimes',
                'date',
                'after_or_equal:today',
            ],

            'date_to' => [
                'sometimes',
                'date',
                'after_or_equal:date_from',
            ],

            'reason' => [
                'sometimes',
                Rule::enum(CustomPriceReason::class),
            ],

            'daily_price' => [

                Rule::requiredIf(function () {

                    return $this->reason
                        === CustomPriceReason::CUSTOM_PRICE->value
                        &&
                        !$this->route('customPrice')->daily_price;

                }),

                Rule::prohibitedIf(function () {

                    return $this->reason
                        === CustomPriceReason::UNAVAILABLE->value;

                }),

                'nullable',
                'numeric',
                'min:0',
            ],

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            /*
            |--------------------------------------------------------------------------
            | Empty Update
            |--------------------------------------------------------------------------
            */

            if ($this->all() === []) {

                $validator->errors()->add(
                    'update',
                    __('car.no_changes')
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Cannot add price to unavailable record
            |--------------------------------------------------------------------------
            */

            $customPrice = $this->route('customPrice');


            if (
                $customPrice->reason === CustomPriceReason::UNAVAILABLE
                &&
                $this->has('daily_price')
                &&
                !$this->has('reason')
            ) {

                $validator->errors()->add(
                    'daily_price',
                    __('car.unavailable_price_not_allowed')
                );

            }


        });
    }
}
