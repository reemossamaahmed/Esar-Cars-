<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CarImage extends Model
{

    protected $fillable = [

        'car_id',

        'image_url',

        'order_index',

        'is_cover',

    ];


    protected $casts = [

        'is_cover' => 'boolean',

    ];


    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

}
