<?php

namespace App\Services\Car;

use App\Models\Car;
use Illuminate\Support\Facades\DB;

class UpdateCarPricingService
{
    public function update(Car $car, array $data)
    {
        return DB::transaction(function () use ($car, $data) {


            $weeklyPrice = $data['weekly_price']
                ?? ($data['daily_price'] * 7);


            $monthlyPrice = $data['monthly_price']
                ?? ($data['daily_price'] * 30);



            $car->pricing()->updateOrCreate(

                [
                    'car_id' => $car->id,
                ],

                [

                    'daily_price' => $data['daily_price'],

                    'weekly_price' => $weeklyPrice,

                    'monthly_price' => $monthlyPrice,

                    'down_payment' => $data['down_payment'] ?? 0,

                    'instant_booking_enabled'
                        => $data['instant_booking_enabled'],

                ]

            );

            /*
            |--------------------------------------------------------------------------
            | Discount Rules
            |--------------------------------------------------------------------------
            */

            if (isset($data['discount_rules'])) {


                $car->discountRules()->delete();


                $car->discountRules()->createMany(

                    $data['discount_rules']

                );

            }


            return $car->load(['pricing', 'discountRules']);

        });
    }
}
