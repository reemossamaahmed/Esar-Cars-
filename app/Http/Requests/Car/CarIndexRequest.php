<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class CarIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Pagination
            |--------------------------------------------------------------------------
            */

            'page' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'per_page' => [
                'sometimes',
                'integer',
                'min:1',
                'max:50',
            ],


            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            'city_id' => [
                'sometimes',
                'integer',
                'exists:cities,id',
            ],


            /*
            |--------------------------------------------------------------------------
            | Car Type
            |--------------------------------------------------------------------------
            */

            'car_type_id' => [
                'sometimes',
                'integer',
                'exists:car_types,id',
            ],


            /*
            |--------------------------------------------------------------------------
            | Price
            |--------------------------------------------------------------------------
            */

            'min_price' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'max_price' => [
                'sometimes',
                'numeric',
                'min:0',
            ],
        ];
    }


    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            /*
            |--------------------------------------------------------------------------
            | Validate Price Range
            |--------------------------------------------------------------------------
            */

            if (
                $this->filled('min_price') &&
                $this->filled('max_price') &&
                $this->min_price > $this->max_price
            ) {
                $validator->errors()->add(
                    'max_price',
                    __('car.max_price_must_be_greater_than_min_price')
                );
            }

        });
    }
}
