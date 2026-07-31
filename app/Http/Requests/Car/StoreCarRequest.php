<?php

namespace App\Http\Requests\Car;

use App\Enums\DrivetrainType;
use App\Enums\TransmissionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCarRequest extends FormRequest
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
            | Car Basic Information
            |--------------------------------------------------------------------------
            */

            'brand_id' => [
                'required',
                'exists:brands,id'
            ],


            'car_model_id' => [
                'required',
                'exists:car_models,id'
            ],


            'car_type_id' => [
                'required',
                'exists:car_types,id'
            ],


            'year' => [
                'required',
                'integer',
                'min:1900',
                'max:' . now()->year
            ],


            'chassis_number' => [
                'required',
                'string',
                'max:255',
                'unique:cars,chassis_number'
            ],


            'seats_count' => [
                'required',
                'integer',
                'min:1'
            ],


            'insurance_value' => [
                'required',
                'numeric',
                'min:0'
            ],


            'transmission' => [
                'required',
                Rule::in(
                    array_column(
                        TransmissionType::cases(),
                        'value'
                    )
                )
            ],


            'drivetrain' => [
                'nullable',
                Rule::in(
                    array_column(
                        DrivetrainType::cases(),
                        'value'
                    )
                )
            ],


            'color' => [
                'required',
                'string',
                'max:100'
            ],


            'km_driven' => [
                'required',
                'integer',
                'min:0'
            ],


            'description' => [
                'nullable',
                'string'
            ],



            /*
            |--------------------------------------------------------------------------
            | Features
            |--------------------------------------------------------------------------
            */

            'features' => [
                'nullable',
                'array'
            ],


            'features.*' => [
                'exists:features,id'
            ],



            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            'location' => [
                'required',
                'array'
            ],


            'location.city_id' => [
                'required',
                'exists:cities,id'
            ],


            'location.address' => [
                'required',
                'string'
            ],


            'location.latitude' => [
                'required',
                'numeric'
            ],


            'location.longitude' => [
                'required',
                'numeric'
            ],

        ];
    }
}
