<?php

namespace App\Services\Car;

use App\Models\Car;
use App\Models\CarCustomPrice;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BusinessException;

class CreateCustomPriceService
{

    public function create(
        Car $car,
        array $data
    ): CarCustomPrice {


        $this->checkConflict(
            $car,
            $data
        );


        return DB::transaction(function () use ($car,$data){

            return $car->customPrices()->create([

                'date_from' => $data['date_from'],

                'date_to' => $data['date_to'],

                'daily_price' =>
                    $data['daily_price'] ?? null,

                'reason' =>
                    $data['reason'],

            ]);

        });

    }




    private function checkConflict( Car $car, array $data): void
    {

        $exists = $car
            ->customPrices()
            ->where(function ($query) use ($data) {

                $query->where(
                    'date_from',
                    '<=',
                    $data['date_to']
                )
                ->where(
                    'date_to',
                    '>=',
                    $data['date_from']
                );

            })
            ->exists();



        if ($exists) {

            throw new BusinessException(
                __('car.custom_price_conflict'),
                422
            );

        }

    }

}
