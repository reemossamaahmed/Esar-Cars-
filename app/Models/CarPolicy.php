<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarPolicy extends Model
{
    protected $fillable = [

        'car_id',

        'cancellation_days',

        'cancellation_details',

    ];


    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
