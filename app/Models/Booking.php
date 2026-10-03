<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'booking_number',

        'car_id',

        'renter_id',

        'pickup_city_id',

        'dropoff_city_id',

        'pickup_at',

        'dropoff_at',

        'status',

        'base_amount',

        'custom_price_adjustment',

        'discount_amount',

        'pickup_fee',

        'dropoff_fee',

        'delivery_fee',

        'deposit_amount',

        'total_amount',

        'payment_method',

        'payment_status',

        'cancellation_reason',

        'cancelled_at',

        'confirmed_at',

        'completed_at',
    ];


    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'pickup_at' => 'datetime',

        'dropoff_at' => 'datetime',

        'cancelled_at' => 'datetime',

        'confirmed_at' => 'datetime',

        'completed_at' => 'datetime',

        'base_amount' => 'decimal:2',

        'custom_price_adjustment' => 'decimal:2',

        'discount_amount' => 'decimal:2',

        'pickup_fee' => 'decimal:2',

        'dropoff_fee' => 'decimal:2',

        'delivery_fee' => 'decimal:2',

        'deposit_amount' => 'decimal:2',

        'total_amount' => 'decimal:2',

        'status' => BookingStatus::class,

        'payment_method' => PaymentMethod::class,

        'payment_status' => PaymentStatus::class,
    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * The renter who created the booking.
     */
    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }


    /**
     * The booked car.
     */
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }


    /**
     * Pickup city.
     */
    public function pickupCity()
    {
        return $this->belongsTo(City::class, 'pickup_city_id');
    }


    /**
     * Dropoff city.
     */
    public function dropoffCity()
    {
        return $this->belongsTo(City::class, 'dropoff_city_id');
    }
}
