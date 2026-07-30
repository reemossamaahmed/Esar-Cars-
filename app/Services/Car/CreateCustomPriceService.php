<?php

namespace App\Services\Car;

use App\Enums\CustomPriceReason;
use App\Exceptions\BusinessException;
use App\Models\Car;
use Illuminate\Support\Facades\DB;

class CreateCustomPriceService
{

    public function create(Car $car, array $data)
    {

        return DB::transaction(function () use ($car, $data) {


            /*
            |--------------------------------------------------------------------------
            | Check Overlapping Dates
            |--------------------------------------------------------------------------
            */

            $exists = $car->customPrices()

                ->where(function ($query) use ($data) {

                    $query

                        ->whereBetween(
                            'date_from',
                            [
                                $data['date_from'],
                                $data['date_to']
                            ]
                        )

                        ->orWhereBetween(
                            'date_to',
                            [
                                $data['date_from'],
                                $data['date_to']
                            ]
                        )

                        ->orWhere(function ($query) use ($data) {

                            $query

                                ->where('date_from', '<=', $data['date_from'])

                                ->where('date_to', '>=', $data['date_to']);

                        });

                })

                ->exists();



            if ($exists) {

                throw new BusinessException(

                    __('car.custom_price_overlap'),

                    422

                );

            }



            /*
            |--------------------------------------------------------------------------
            | Create Custom Price
            |--------------------------------------------------------------------------
            */

            $car->customPrices()->create([

                'date_from' => $data['date_from'],

                'date_to' => $data['date_to'],

                'daily_price' => $data['daily_price'],

                'reason' => CustomPriceReason::CUSTOM_PRICE,

            ]);


            return $car->load('customPrices');

        });

    }

}
