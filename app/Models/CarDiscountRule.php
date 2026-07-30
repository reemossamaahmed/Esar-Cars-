<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDiscountRule extends Model
{

    protected $fillable = [

        'car_id',

        'min_days',

        'discount_percent',

    ];


    protected $casts = [

        'discount_percent' => 'decimal:2',

    ];


    public function car()
    {
        return $this->belongsTo(Car::class);
    }

}
