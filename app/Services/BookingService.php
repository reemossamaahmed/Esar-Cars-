<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Models\Car;
use App\Models\User;
use App\Models\Booking;
use App\Enums\CarStatus;
use App\Enums\BookingStatus;

class BookingService
{
    /** * Create a new booking. */
    public function createBooking(User $renter, array $data)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Renter Authorization
        |--------------------------------------------------------------------------
        */
        if (!$renter->hasRole('renter'))
        {
            throw new BusinessException( __('booking.only_renter_can_book'), 422 );
        }
        /*
        |--------------------------------------------------------------------------
        | 2. Get Car
        |--------------------------------------------------------------------------
        */
        $car = Car::with([ 'pricing', 'location', 'policy', ])->find($data['car_id']);
        /*
        |--------------------------------------------------------------------------
        | 3. Car Must Exist
        |--------------------------------------------------------------------------
        */
        if (!$car)
        {
            throw new BusinessException( __('booking.car_not_found'), 404 );
        }
        /*
        |--------------------------------------------------------------------------
        | 4. Car Must Be Published
        |--------------------------------------------------------------------------
        */
        if ($car->status !== CarStatus::PUBLISHED) {
            throw new BusinessException(
                __('booking.car_not_available'),
                422
            );
        }
        /*
        |--------------------------------------------------------------------------
        | 5. Car Must Have Pricing
        |--------------------------------------------------------------------------
        */
        if (!$car->pricing)
        {
            throw new BusinessException( __('booking.pricing_not_configured'), 422 );
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Validate Booking Period
        |--------------------------------------------------------------------------
        */
        $pickupAt = $data['pickup_at'];
        $dropoffAt = $data['dropoff_at'];
        /*
        |--------------------------------------------------------------------------
        | Pickup must be before Dropoff
        |--------------------------------------------------------------------------
        */
        if ($pickupAt >= $dropoffAt)
        {
            throw new BusinessException( __('booking.invalid_period'), 422 );
        }
        /*
        |--------------------------------------------------------------------------
        | 7. Check Car Availability
        |--------------------------------------------------------------------------
        */
        $hasConflict = Booking::query()
                                ->where('car_id', $car->id)
                                ->whereIn('status', [ BookingStatus::PENDING, BookingStatus::CONFIRMED, BookingStatus::ACTIVE, ])
                                ->where(function ($query) use ($pickupAt, $dropoffAt)
                                { $query ->where('pickup_at', '<', $dropoffAt) ->where('dropoff_at', '>', $pickupAt); })
                                ->exists();
                                if ($hasConflict)
                                {
                                    throw new BusinessException( __('booking.car_not_available_for_selected_period'), 422 );
                                }
        return $car;
    }
}
