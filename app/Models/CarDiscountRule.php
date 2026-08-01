<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDiscountRule extends Model
{

    protected $fillable = [

        'car_pricing_id',

        'title',

        'total_price',

        'from_days',

        'to_days',

    ];


    protected $casts = [

        'total_price' => 'decimal:2',

    ];


    public function pricing()
    {
        return $this->belongsTo(CarPricing::class, 'car_pricing_id');
    }
}
