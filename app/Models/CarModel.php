<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class CarModel extends Model
{
    use HasUuids;

    protected $fillable = [
        'brand_id',
        'name',
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
