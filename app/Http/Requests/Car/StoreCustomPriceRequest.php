<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CustomPriceReason;
use Illuminate\Validation\Rule;

class StoreCustomPriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'date_from' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'date_to' => [
                'required',
                'date',
                'after_or_equal:date_from',
            ],

            'reason' => [

                'required',

                Rule::enum(CustomPriceReason::class),

            ],

            'daily_price' => [
                Rule::requiredIf(
                    fn () => $this->reason === CustomPriceReason::CUSTOM_PRICE->value
                ),
                Rule::prohibitedIf(
                    fn () => $this->reason === CustomPriceReason::UNAVAILABLE->value
                ),
                'nullable',
                'numeric',
                'min:0',

            ],

        ];
    }

}
