<?php

namespace App\Http\Requests\Car;

use App\Enums\DrivetrainType;
use App\Enums\TransmissionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $car = $this->route('car');

        return [

            /*
            |--------------------------------------------------------------------------
            | Car Basic Information
            |--------------------------------------------------------------------------
            */

            'brand_id' => [
                'sometimes',
                'exists:brands,id',
            ],

            'car_model_id' => [
                'sometimes',
                'exists:car_models,id',
            ],

            'car_type_id' => [
                'sometimes',
                'exists:car_types,id',
            ],

            'year' => [
                'sometimes',
                'integer',
                'min:1900',
                'max:' . now()->year,
            ],

            'chassis_number' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('cars', 'chassis_number')
                    ->ignore($car->id),
            ],

            'seats_count' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'insurance_value' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'transmission' => [
                'sometimes',
                Rule::in(
                    array_column(
                        TransmissionType::cases(),
                        'value'
                    )
                ),
            ],

            'drivetrain' => [
                'sometimes',
                'nullable',
                Rule::in(
                    array_column(
                        DrivetrainType::cases(),
                        'value'
                    )
                ),
            ],

            'color' => [
                'sometimes',
                'string',
                'max:100',
            ],

            'km_driven' => [
                'sometimes',
                'integer',
                'min:0',
            ],

            'description' => [
                'sometimes',
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Features
            |--------------------------------------------------------------------------
            */

            'features' => [
                'sometimes',
                'array',
            ],

            'features.*' => [
                'exists:features,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            'location' => [
                'sometimes',
                'array',
            ],

            'location.city_id' => [
                'required_with:location',
                'exists:cities,id',
            ],

            'location.address' => [
                'required_with:location',
                'string',
            ],

            'location.latitude' => [
                'required_with:location',
                'numeric',
            ],

            'location.longitude' => [
                'required_with:location',
                'numeric',
            ],

        ];
    }
}
