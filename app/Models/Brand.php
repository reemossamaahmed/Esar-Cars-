<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $fillable = [
        'name_en',
        'name_ar',
        'slug',
        'logo_url',
        'is_active'
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

    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }
}
