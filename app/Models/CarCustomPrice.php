<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CarCustomPrice extends Model
{

    protected $fillable = [

        'car_id',

        'date_from',

        'date_to',

        'price',

        'reason',

    ];


    protected $casts = [

        'date_from' => 'date',

        'date_to' => 'date',

        'price' => 'decimal:2',

    ];


    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

}
