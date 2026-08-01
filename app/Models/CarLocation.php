<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarLocation extends Model
{
    protected $fillable = [

        'car_id',

        'city_id',

        'address',

        'latitude',

        'longitude',

    ];

    protected $casts = [

        'latitude' => 'decimal:7',

        'longitude' => 'decimal:7',

    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
