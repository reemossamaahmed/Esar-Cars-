<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarHandoverPolicy extends Model
{
    protected $fillable = [

        'car_id',

        'pickup_method',

        'dropoff_method',

        'pickup_fee',

        'dropoff_fee',

        'is_active',

    ];

    protected $casts = [

        'pickup_fee' => 'decimal:2',

        'dropoff_fee' => 'decimal:2',

        'is_active' => 'boolean',

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
