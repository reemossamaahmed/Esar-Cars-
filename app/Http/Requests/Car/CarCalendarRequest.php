<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class CarCalendarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'year' => [
                'required',
                'integer',
                'min:2020',
            ],


            'month' => [
                'required',
                'integer',
                'between:1,12',
            ],

        ];
    }
}
