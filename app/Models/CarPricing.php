<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarPricing extends Model
{
    protected $fillable = [

        'car_id',

        'daily_price',

        'weekly_price',

        'monthly_price',

        'down_payment',

        'instant_booking_enabled',

    ];


    protected $casts = [

        'daily_price' => 'decimal:2',

        'weekly_price' => 'decimal:2',

        'monthly_price' => 'decimal:2',

        'down_payment' => 'decimal:2',

        'instant_booking_enabled' => 'boolean',

    ];


    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
