<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'slug',
        'icon_url',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
