<?php

namespace App\Services\Car;

use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Enums\CarStatus;

class CarService
{
    public function index(array $filters)
    {
        $query = Car::query()
            ->where('status', CarStatus::PUBLISHED->value)
            ->with([
                'brand',
                'carModel',
                'carType',
                'features',
                'location.city',
                'pricing',
                'pricing.discountRules',
                'images',
                'policy',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Location
        |--------------------------------------------------------------------------
        */

        if (isset($filters['city_id'])) {
            $query->whereHas('location', function ($q) use ($filters) {
                $q->where('city_id', $filters['city_id']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Car Type
        |--------------------------------------------------------------------------
        */

        if (isset($filters['car_type_id'])) {
            $query->where(
                'car_type_id',
                $filters['car_type_id']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Price
        |--------------------------------------------------------------------------
        */

        if (isset($filters['min_price'])) {
            $query->whereHas('pricing', function ($q) use ($filters) {
                $q->where(
                    'daily_price',
                    '>=',
                    $filters['min_price']
                );
            });
        }

        if (isset($filters['max_price'])) {
            $query->whereHas('pricing', function ($q) use ($filters) {
                $q->where(
                    'daily_price',
                    '<=',
                    $filters['max_price']
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        return $query
            ->latest()
            ->paginate(
                $filters['per_page'] ?? 10
            );
    }

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



    private function generateSlug(int $brandId,int $modelId): string
    {

        return Str::slug(
            $brandId . '-' . $modelId . '-' . Str::random(6)
        );

    }

    public function update(Car $car, array $data): Car
    {

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
