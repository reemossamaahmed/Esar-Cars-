<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarDiscountRule extends Model
{

    protected $fillable = [

        'car_id',

        'min_days',

        'discount_percent',

        'is_active',

    ];


    protected $casts = [

        'discount_percent' => 'decimal:2',

        'is_active' => 'boolean',

    ];


    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

}
