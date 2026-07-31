<?php

namespace App\Services\Car;

use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Enums\CarStatus;

class CreateCarService
{

    public function create(array $data): Car
    {
        return DB::transaction(function () use ($data) {


            /*
            |--------------------------------------------------------------------------
            | Create Car
            |--------------------------------------------------------------------------
            */

            $car = Car::create([

                'id' => Str::uuid(),

                'owner_id' => auth('api')->id(),

                'brand_id' => $data['brand_id'],

                'car_model_id' => $data['car_model_id'],

                'car_type_id' => $data['car_type_id'],

                'year' => $data['year'],

                'slug' => $this->generateSlug(
                    $data['brand_id'],
                    $data['car_model_id']
                ),

                'chassis_number' => $data['chassis_number'],

                'seats_count' => $data['seats_count'],

                'insurance_value' => $data['insurance_value'],

                'transmission' => $data['transmission'],

                'drivetrain' => $data['drivetrain'] ?? null,

                'color' => $data['color'],

                'km_driven' => $data['km_driven'],

                'description' => $data['description'] ?? null,

                'status'=>CarStatus::DRAFT->value

            ]);



            /*
            |--------------------------------------------------------------------------
            | Attach Features
            |--------------------------------------------------------------------------
            */

            if (!empty($data['features'])) {

                $car->features()
                    ->sync($data['features']);

            }



            /*
            |--------------------------------------------------------------------------
            | Create Location
            |--------------------------------------------------------------------------
            */

            $car->location()->create([

                'city_id' => $data['location']['city_id'],

                'address' => $data['location']['address'],

                'latitude' => $data['location']['latitude'],

                'longitude' => $data['location']['longitude'],

            ]);



            return $car->load([
                'brand',
                'carModel',
                'carType',
                'features',
                'location.city'
            ]);

        });
    }



    private function generateSlug(
        int $brandId,
        int $modelId
    ): string {

        return Str::slug(
            $brandId . '-' . $modelId . '-' . Str::random(6)
        );

    }

}
