<?php

namespace App\Models;

use App\Enums\CustomPriceReason;
use Illuminate\Database\Eloquent\Model;

class CarCustomPrice extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'car_id',

        'date_from',

        'date_to',

        'daily_price',

        'reason',

    ];



    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'date_from' => 'date',

        'date_to' => 'date',

        'daily_price' => 'decimal:2',

        'reason' => CustomPriceReason::class,

    ];



    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
