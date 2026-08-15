<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarPricingRequest extends FormRequest
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
            | Base Prices
            |--------------------------------------------------------------------------
            */

            'daily_price' => [
                'required',
                'numeric',
                'min:0',
            ],


            'monthly_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],


            'yearly_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],


            /*
            |--------------------------------------------------------------------------
            | External Booking
            |--------------------------------------------------------------------------
            */

            'external_booking_enabled' => [
                'nullable',
                'boolean',
            ],



            /*
            |--------------------------------------------------------------------------
            | Deposit
            |--------------------------------------------------------------------------
            */

            'deposit' => [
                'nullable',
                'array',
            ],


            'deposit.title' => [
                'required_with:deposit',
                'string',
                'max:255',
            ],


            'deposit.description' => [
                'nullable',
                'string',
            ],


            'deposit.price' => [
                'required_with:deposit',
                'numeric',
                'min:0',
            ],



            /*
            |--------------------------------------------------------------------------
            | Discount Rules
            |--------------------------------------------------------------------------
            */

            'discount_rules' => [
                'nullable',
                'array',
            ],


            'discount_rules.*.title' => [
                'required',
                'string',
                'max:255',
            ],


            'discount_rules.*.total_price' => [
                'required',
                'numeric',
                'min:0',
            ],


            'discount_rules.*.from_days' => [
                'required',
                'integer',
                'min:1',
            ],


            'discount_rules.*.to_days' => [
                'required',
                'integer',
            ],



        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            foreach ($this->discount_rules ?? [] as $index => $rule) {

                if (
                    isset($rule['from_days'], $rule['to_days'])
                    &&
                    $rule['to_days'] < $rule['from_days']
                ) {

                    $validator->errors()->add(
                        "discount_rules.$index.to_days",
                        __('validation.discount_days_invalid')
                    );

                }

            }

        });
    }
}
