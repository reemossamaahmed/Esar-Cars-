<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarPricing extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'car_id',

        'daily_price',

        'monthly_price',

        'yearly_price',

        'instant_booking_enabled',

        'deposit_title',

        'deposit_description',

        'deposit_price',

    ];


    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'daily_price'   => 'decimal:2',

        'monthly_price' => 'decimal:2',

        'yearly_price'  => 'decimal:2',

        'instant_booking_enabled' => 'boolean',



    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    /**
     * Pricing belongs to one car
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }


    /**
     * Pricing has many discount rules
     */
    public function discountRules()
    {
        return $this->hasMany(CarDiscountRule::class);
    }

}
