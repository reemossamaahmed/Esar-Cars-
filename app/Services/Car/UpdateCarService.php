<?php

namespace App\Services\Car;

use App\Models\Car;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateCarService
{

    public function update(Car $car, array $data): Car {

        return DB::transaction(function () use ($car, $data) {


            /*
            |--------------------------------------------------------------------------
            | Update Basic Information
            |--------------------------------------------------------------------------
            */


            $basicData = Arr::only(
                $data,
                [

                    'brand_id',

                    'car_model_id',

                    'car_type_id',

                    'year',

                    'chassis_number',

                    'seats_count',

                    'insurance_value',

                    'transmission',

                    'drivetrain',

                    'color',

                    'km_driven',

                    'description',

                ]
            );


            if (!empty($basicData)) {

                $car->update($basicData);

            }



            /*
            |--------------------------------------------------------------------------
            | Update Features
            |--------------------------------------------------------------------------
            */


            if (array_key_exists('features', $data)) {

                $car->features()
                    ->sync($data['features']);

            }



            /*
            |--------------------------------------------------------------------------
            | Update Location
            |--------------------------------------------------------------------------
            */


            if (array_key_exists('location', $data)) {


                $car->location()
                    ->updateOrCreate(

                        [],

                        [

                            'city_id' =>
                                $data['location']['city_id'],

                            'address' =>
                                $data['location']['address'],

                            'latitude' =>
                                $data['location']['latitude'],

                            'longitude' =>
                                $data['location']['longitude'],

                        ]

                    );

            }

            return $car->fresh()->load([

                'brand',

                'carModel',

                'carType',

                'features',

                'location.city',

                'images',

                'pricing',

                'pricing.discountRules',

                'policy',

            ]);

        });

    }

}
