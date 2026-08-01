<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [

        'name_en',

        'name_ar',

        'country',

        'is_active',

    ];

    protected $casts = [

        'is_active' => 'boolean',

    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
