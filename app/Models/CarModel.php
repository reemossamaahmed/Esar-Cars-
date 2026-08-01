<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CarModel extends Model
{

    protected $fillable = [
        'brand_id',
        'name_en',
        'name_ar',
        'slug',
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

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
