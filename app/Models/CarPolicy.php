<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarPolicy extends Model
{
    protected $fillable = [

        'car_id',

        'days_before',

        'policy_text',

        'is_active'

    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
