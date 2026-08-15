<?php

namespace App\Services\Car;

use App\Models\Car;
use App\Models\CarPricing;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BusinessException;

class CarPricingService
{

    public function create(Car $car, array $data): CarPricing
    {
        return DB::transaction(function () use ($car, $data) {


            /*
            |--------------------------------------------------------------------------
            | Prepare Prices
            |--------------------------------------------------------------------------
            */

            $prices = $this->preparePrices($data);



            /*
            |--------------------------------------------------------------------------
            | Save Pricing
            |--------------------------------------------------------------------------
            */
            $exists = CarPricing::where('car_id', $car->id)->exists();


            if ($exists) {

                throw new BusinessException(
                    __('car.pricing_exists'),
                    422
                );

            }

            $pricing = CarPricing::create([ 'car_id' => $car->id,...$prices]);



            /*
            |--------------------------------------------------------------------------
            | Save Deposit
            |--------------------------------------------------------------------------
            */

            $this->saveDeposit($pricing, $data['deposit'] ?? null);



            /*
            |--------------------------------------------------------------------------
            | Sync Discount Rules
            |--------------------------------------------------------------------------
            */

            $this->syncDiscountRules(
                $pricing, $data['discount_rules'] ?? []);


            return $pricing->load([
                'discountRules'
            ]);

        });
    }

    public function update(Car $car, array $data): CarPricing
    {
        return DB::transaction(function () use ($car, $data) {

            $pricing = $car->pricing;


            if (!$pricing) {

                throw new BusinessException(
                    __('car.pricing_not_found'),
                    404
                );

            }


            $prices = $this->prepareUpdatePrices(
                $pricing,
                $data
            );


            $pricing->update($prices);

            if (array_key_exists('deposit', $data)) {

                $this->saveDeposit(
                    $pricing,
                    $data['deposit']
                );

            }


            if (array_key_exists('discount_rules', $data)) {

                $this->syncDiscountRules(
                    $pricing,
                    $data['discount_rules']
                );

            }


            return $pricing->load([
                'discountRules'
            ]);

        });
    }



    private function preparePrices(array $data): array
    {

        $daily = $data['daily_price'];


        return [

            'daily_price' => $daily,


            'monthly_price'
                => $data['monthly_price']
                ?? ($daily * 30),


            'yearly_price'
                => $data['yearly_price']
                ?? ($daily * 365),


            'external_booking_enabled'
                => $data['external_booking_enabled'] ?? false,

        ];
    }


    private function prepareUpdatePrices(CarPricing $pricing, array $data): array
    {

        $daily = $data['daily_price']
            ?? $pricing->daily_price;


        return [

            'daily_price' => $daily,


            'monthly_price'
                => $data['monthly_price']
                ?? ($daily * 30),


            'yearly_price'
                => $data['yearly_price']
                ?? ($daily * 365),


            'external_booking_enabled'
                => $data['external_booking_enabled']
                ?? $pricing->external_booking_enabled,

        ];
    }

    private function saveDeposit(CarPricing $pricing, ?array $deposit): void
    {
        /*
        |--------------------------------------------------------------------------
        | No Deposit
        |--------------------------------------------------------------------------
        */

        if (!$deposit) {

            $pricing->update([

                'deposit_title'       => null,

                'deposit_description' => null,

                'deposit_price'       => null,

            ]);

            return;
        }



        /*
        |--------------------------------------------------------------------------
        | Save Deposit
        |--------------------------------------------------------------------------
        */

        $pricing->update([

            'deposit_title'
                => $deposit['title'],


            'deposit_description'
                => $deposit['description'] ?? null,


            'deposit_price'
                => $deposit['price'],

        ]);
    }

    private function syncDiscountRules(CarPricing $pricing, array $rules): void
    {

        /*
        |--------------------------------------------------------------------------
        | No Offers
        |--------------------------------------------------------------------------
        */

        if (empty($rules)) {

            $pricing->discountRules()->delete();

            return;
        }



        /*
        |--------------------------------------------------------------------------
        | Check Conflict
        |--------------------------------------------------------------------------
        */

        $this->checkDiscountConflicts($rules);



        /*
        |--------------------------------------------------------------------------
        | Replace Old Rules
        |--------------------------------------------------------------------------
        */

        $pricing->discountRules()->delete();



        /*
        |--------------------------------------------------------------------------
        | Create New Rules
        |--------------------------------------------------------------------------
        */

        foreach ($rules as $rule) {

            $pricing->discountRules()->create([

                'title' => $rule['title'],

                'total_price' => $rule['total_price'],

                'from_days' => $rule['from_days'],

                'to_days' => $rule['to_days'],

            ]);

        }

    }

    private function checkDiscountConflicts(array $rules): void
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Days Range
        |--------------------------------------------------------------------------
        */

        foreach ($rules as $rule) {

            if ($rule['to_days'] < $rule['from_days']) {

                throw new BusinessException(
                    __('car.invalid_discount_period'),
                    422
                );

            }

        }



        /*
        |--------------------------------------------------------------------------
        | Check Overlapping Rules
        |--------------------------------------------------------------------------
        */

        foreach ($rules as $index => $rule) {


            foreach ($rules as $secondIndex => $secondRule) {


                /*
                |--------------------------------------------------------------------------
                | Skip Same Rule
                |--------------------------------------------------------------------------
                */

                if ($index === $secondIndex) {
                    continue;
                }



                /*
                |--------------------------------------------------------------------------
                | Check Overlap
                |--------------------------------------------------------------------------
                |
                | Example:
                |
                | Rule 1: 1 -> 7 days
                | Rule 2: 5 -> 10 days
                |
                | Conflict because 5-7 exists in both
                |
                */

                $overlap =
                    $rule['from_days'] <= $secondRule['to_days']
                    &&
                    $rule['to_days'] >= $secondRule['from_days'];



                if ($overlap) {

                    throw new BusinessException(
                        __('car.discount_conflict'),
                        422
                    );

                }

            }

        }
    }



}
