<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarDocumentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Owner Documents
            |--------------------------------------------------------------------------
            */

            'owner_document' => ['required', 'array'],

            'owner_document.national_id' => [
                'required',
                'string',
                'max:30',
            ],

            'owner_document.issue_city_id' => [
                'required',
                'exists:cities,id',
            ],

            'owner_document.issue_date' => [
                'required',
                'date',
            ],

            'owner_document.expiry_date' => [
                'required',
                'date',
                'after:owner_document.issue_date',
            ],

            'owner_document.id_card_image_url' => [
                'required',
                'url',
                'max:2048',
            ],


            /*
            |--------------------------------------------------------------------------
            | Car Documents
            |--------------------------------------------------------------------------
            */

            'car_document' => ['required', 'array'],

            'car_document.license_number' => [
                'required',
                'string',
                'max:100',
            ],

            'car_document.insurance_policy_number' => [
                'required',
                'string',
                'max:100',
            ],

            'car_document.issue_date' => [
                'required',
                'date',
            ],

            'car_document.expiry_date' => [
                'required',
                'date',
                'after:car_document.issue_date',
            ],

            'car_document.vehicle_document_url' => [
                'required',
                'url',
                'max:2048',
            ],

        ];
    }
}
