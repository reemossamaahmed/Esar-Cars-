<?php

namespace App\Services\Car;

use App\Exceptions\BusinessException;
use App\Models\Car;
use App\Models\CarHandoverPolicy;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class CarHandoverPolicyService
{
    public function save(Car $car, User $owner, array $data): CarHandoverPolicy
    {

        return DB::transaction(function () use ($car, $owner, $data) {

            /*
            |--------------------------------------------------------------------------
            | 1. Verify ownership
            |--------------------------------------------------------------------------
            */

            if ($car->owner_id !== $owner->id) {
                throw new BusinessException(
                    __('car_handover_policy.unauthorized'),
                    403
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 2. Normalize pickup fee
            |--------------------------------------------------------------------------
            */

            $pickupFee = $data['pickup_fee'] ?? 0;

            if ($data['pickup_method'] === 'renter_pickup') {
                $pickupFee = 0;
            }


            /*
            |--------------------------------------------------------------------------
            | 3. Normalize drop-off fee
            |--------------------------------------------------------------------------
            */

            $dropoffFee = $data['dropoff_fee'] ?? 0;

            if ($data['dropoff_method'] === 'renter_return') {
                $dropoffFee = 0;
            }


            /*
            |--------------------------------------------------------------------------
            | 4. Create / Update Policy
            |--------------------------------------------------------------------------
            */

            $policy = $car->handoverPolicy()->updateOrCreate(
                [
                    'car_id' => $car->id,
                ],
                [
                    'pickup_method' => $data['pickup_method'],

                    'dropoff_method' => $data['dropoff_method'],

                    'pickup_fee' => $pickupFee,

                    'dropoff_fee' => $dropoffFee,

                    'is_active' => $data['is_active'] ?? true,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | 5. Return Policy
            |--------------------------------------------------------------------------
            */

            return $policy->refresh();
        });
    }

    public function getPolicy(Car $car): CarHandoverPolicy
    {
        $policy = $car->handoverPolicy;

        if (!$policy) {
            throw new BusinessException(
                __('car_handover_policy.not_found'),
                404
            );
        }

        return $policy;
    }
}
