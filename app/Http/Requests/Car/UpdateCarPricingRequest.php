<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarPricingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'daily_price' => [
                'required',
                'numeric',
                'min:0',
            ],


            'weekly_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],


            'monthly_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],


            'down_payment' => [
                'nullable',
                'numeric',
                'min:0',
            ],


            'instant_booking_enabled' => [
                'required',
                'boolean',
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


            'discount_rules.*.min_days' => [
                'required',
                'integer',
                'min:1',
            ],


            'discount_rules.*.discount_percent' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

        ];
    }
}
