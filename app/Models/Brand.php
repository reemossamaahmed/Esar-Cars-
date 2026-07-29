<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Brand extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
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
