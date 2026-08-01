<?php

namespace App\Services\Car;

use App\Models\Car;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class GetCarCalendarService
{
    public function get(Car $car, ?int $month, ?int $year): array
    {

        /*
        |--------------------------------------------------------------------------
        | Default Month
        |--------------------------------------------------------------------------
        */

        $month ??= now()->month;

        $year ??= now()->year;



        /*
        |--------------------------------------------------------------------------
        | Get Car Custom Prices
        |--------------------------------------------------------------------------
        */

        $customPrices = $car->customPrices()
            ->where(function ($query) use ($year, $month) {

                $query

                    ->whereMonth('date_from', $month)
                    ->whereYear('date_from', $year)

                    ->orWhere(function ($query) use ($year, $month) {

                        $query

                            ->whereMonth('date_to', $month)
                            ->whereYear('date_to', $year);

                    });

            })
            ->get();



        /*
        |--------------------------------------------------------------------------
        | Generate Month Days
        |--------------------------------------------------------------------------
        */

        $start = Carbon::create(
            $year,
            $month,
            1
        );


        $end = $start->copy()->endOfMonth();



        $days = [];



        foreach (CarbonPeriod::create($start, $end) as $date) {


            $dateString = $date->toDateString();



            /*
            |--------------------------------------------------------------------------
            | Default Status
            |--------------------------------------------------------------------------
            */

            $day = [

                'date' => $dateString,

                'status' => 'available',

                'price' => null,

            ];



            /*
            |--------------------------------------------------------------------------
            | Check Custom Price
            |--------------------------------------------------------------------------
            */

            $customPrice = $customPrices
                ->first(function ($price) use ($dateString) {


                    return $dateString >= $price->date_from->toDateString()

                        &&

                        $dateString <= $price->date_to->toDateString();

                });



            if ($customPrice) {


                $day['status'] = 'custom_price';


                $day['price'] = $customPrice->daily_price;


            }



            $days[] = $day;

        }



        return [

            'month' => $month,

            'year' => $year,

            'days' => $days,

        ];

    }
}
