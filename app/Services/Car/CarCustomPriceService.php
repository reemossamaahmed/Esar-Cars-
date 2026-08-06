<?php

namespace App\Services\Car;

use App\Models\Car;
use App\Models\CarCustomPrice;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BusinessException;
use App\Enums\CustomPriceReason;
class CarCustomPriceService
{

    public function create(Car $car, array $data): CarCustomPrice
    {


        $this->checkConflict($car, $data);


        return DB::transaction(function () use ($car,$data){

            return $car->customPrices()->create([

                'date_from' => $data['date_from'],

                'date_to' => $data['date_to'],

                'daily_price' => $data['daily_price'] ?? null,

                'reason' => $data['reason'],

            ]);

        });

    }


    public function update(Car $car, CarCustomPrice $customPrice,array $data): CarCustomPrice
    {

        /*
        |--------------------------------------------------------------------------
        | Merge Missing Data
        |--------------------------------------------------------------------------
        */

        $data = array_merge(

            [

                'date_from' => $customPrice->date_from->toDateString(),

                'date_to' => $customPrice->date_to->toDateString(),

                'daily_price' => $customPrice->daily_price,

                'reason' => $customPrice->reason->value,

            ],

            $data

        );



        /*
        |--------------------------------------------------------------------------
        | Check Conflict
        |--------------------------------------------------------------------------
        */

        $this->checkConflict(

            $car,

            $data,

            $customPrice

        );



        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        return DB::transaction(function () use ($customPrice, $data)
        {
            if (isset($data['reason']) && $data['reason'] === CustomPriceReason::UNAVAILABLE->value)
            {
                $data['daily_price'] = null;
            }

            $customPrice->update([

                'date_from' => $data['date_from'],

                'date_to' => $data['date_to'],

                'daily_price' => $data['daily_price'],

                'reason' => $data['reason'],

            ]);

            return $customPrice->refresh();

        });

    }

    private function checkConflict(Car $car, array $data, ?CarCustomPrice $ignore = null): void
    {

        $query = $car->customPrices()

            ->where(function ($query) use ($data) {

                $query
                    ->where('date_from', '<=', $data['date_to'])
                    ->where('date_to', '>=', $data['date_from']);

            });

        /*
        |--------------------------------------------------------------------------
        | Ignore Current Record In Update
        |--------------------------------------------------------------------------
        */

        if ($ignore) {

            $query->whereKeyNot($ignore->id);

        }

        /*
        |--------------------------------------------------------------------------
        | Conflict Exists
        |--------------------------------------------------------------------------
        */

        if ($query->exists()) {

            throw new BusinessException(
                __('car.custom_price_conflict'),
                422
            );

        }

    }

}
