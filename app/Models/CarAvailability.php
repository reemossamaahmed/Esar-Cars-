<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarAvailability extends Model
{

    protected $fillable = [

        'car_id',

        'date_from',

        'date_to',

        'status',

        'reason',

        'note',

    ];


    protected $casts = [

        'date_from' => 'date',

        'date_to' => 'date',

    ];


    public function car()
    {
        return $this->belongsTo(Car::class);
    }

}
