<?php

namespace App\Services\Car;

use App\Enums\CustomPriceReason;
use App\Models\Car;
use Carbon\Carbon;

class CarCalendarService
{
    public function getCalendar(Car $car, array $data): array
    {
        $start = Carbon::create(
            $data['year'],
            $data['month'],
            1
        )->startOfMonth();

        $end = $start->copy()->endOfMonth();

        $pricing = $car->pricing;

        $defaultPrice = $pricing?->daily_price;

        $customPrices = $car
            ->customPrices()
            ->where('date_from', '<=', $end)
            ->where('date_to', '>=', $start)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Build Calendar Map
        |--------------------------------------------------------------------------
        */

        $calendarMap = [];

        foreach ($customPrices as $customPrice) {

            $periodStart = Carbon::parse($customPrice->date_from);

            $periodEnd = Carbon::parse($customPrice->date_to);

            $current = $periodStart->copy();

            while ($current->lte($periodEnd)) {

                $date = $current->format('Y-m-d');

                $calendarMap[$date] = [

                    'status' => $customPrice->reason->value,

                    'price' => $customPrice->reason === CustomPriceReason::CUSTOM_PRICE
                        ? $customPrice->daily_price
                        : null,

                ];

                $current->addDay();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Build Month Response
        |--------------------------------------------------------------------------
        */

        $days = [];

        $currentDay = $start->copy();

        while ($currentDay->lte($end)) {

            $date = $currentDay->format('Y-m-d');

            $day = $calendarMap[$date] ?? [

                'status' => 'available',

                'price' => $defaultPrice,

            ];

            $days[] = [

                'date' => $date,

                'status' => $day['status'],

                'price' => $day['price'],

            ];

            $currentDay->addDay();
        }

        return [

            'year' => (int) $data['year'],

            'month' => (int) $data['month'],

            'days' => $days,

        ];
    }
}
