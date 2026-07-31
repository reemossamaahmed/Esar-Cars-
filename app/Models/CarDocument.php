<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDocument extends Model
{
    /**
     * Mass Assignment
     */
    protected $fillable = [

        'car_id',

        'license_number',

        'insurance_policy_number',

        'issue_date',

        'expiry_date',

        'vehicle_document_url',

    ];

    /**
     * Casts
     */
    protected $casts = [

        'issue_date'  => 'date',

        'expiry_date' => 'date',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
