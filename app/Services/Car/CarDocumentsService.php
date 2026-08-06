<?php

namespace App\Services\Car;

use App\Models\Car;
use App\Models\CarDocument;
use App\Models\OwnerDocument;
use Illuminate\Support\Facades\DB;

class CarDocumentsService
{
    public function save(Car $car, array $data): Car
    {
        return DB::transaction(function () use ($car, $data) {

            /*
            |--------------------------------------------------------------------------
            | Owner Documents
            |--------------------------------------------------------------------------
            */

            OwnerDocument::updateOrCreate(

                [
                    'user_id' => $car->owner_id,
                ],

                [
                    'national_id'       => $data['owner_document']['national_id'],

                    'issue_city_id'     => $data['owner_document']['issue_city_id'],

                    'issue_date'        => $data['owner_document']['issue_date'],

                    'expiry_date'       => $data['owner_document']['expiry_date'],

                    'id_card_image_url' => $data['owner_document']['id_card_image_url'],
                ]

            );



            /*
            |--------------------------------------------------------------------------
            | Car Documents
            |--------------------------------------------------------------------------
            */

            CarDocument::updateOrCreate(

                [
                    'car_id' => $car->id,
                ],

                [

                    'license_number'
                        => $data['car_document']['license_number'],

                    'insurance_policy_number'
                        => $data['car_document']['insurance_policy_number'],

                    'issue_date'
                        => $data['car_document']['issue_date'],

                    'expiry_date'
                        => $data['car_document']['expiry_date'],

                    'vehicle_document_url'
                        => $data['car_document']['vehicle_document_url'],

                ]

            );


            return $car->load([
                'brand',
                'carModel',
                'carType',
                'features',
                'location.city',
                'document',
            ]);
        });
    }
}

