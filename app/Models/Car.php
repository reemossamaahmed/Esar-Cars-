<?php

namespace App\Models;

use App\Enums\CarStatus;
use App\Enums\TransmissionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Car extends Model
{
    use HasUuids;

    /**
     * UUID Configuration
     */
    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * Mass Assignment
     */
    protected $fillable = [

        'owner_id',

        'brand_id',

        'car_model_id',

        'car_type_id',

        'slug',

        'year',

        'chassis_number',

        'seats_count',

        'insurance_value',

        'transmission',

        'drivetrain',

        'color',

        'km_driven',

        'description',

        'status',

        'is_special_offer',

        'is_free_delivery',

        'rating_count',

        'rating_avg',

        'published_at',
    ];

    /**
     * Casts
     */
    protected $casts = [

        'insurance_value' => 'decimal:2',

        'rating_avg' => 'decimal:2',

        'is_special_offer' => 'boolean',

        'is_free_delivery' => 'boolean',

        'status' => CarStatus::class,

        'transmission' => TransmissionType::class,

        'published_at' => 'date',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }

    public function location()
    {
        return $this->hasOne(CarLocation::class);
    }

    public function document()
    {
        return $this->hasOne(CarDocument::class);
    }
    

    public function pricing()
    {
        return $this->hasOne(CarPricing::class);
    }

    public function discountRules()
    {
        return $this->hasMany(CarDiscountRule::class);
    }

    public function customPrices()
    {
        return $this->hasMany(CarCustomPrice::class);
    }

    public function availabilities()
    {
        return $this->hasMany(CarAvailability::class);
    }

    public function images()
    {
        return $this->hasMany(CarImage::class)
            ->orderBy('sort_order');
    }

    public function policy()
    {
        return $this->hasOne(CarPolicy::class);
    }
}
