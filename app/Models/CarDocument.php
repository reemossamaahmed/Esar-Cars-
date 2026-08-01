<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDocument extends Model
{
    protected $fillable = [

        'car_id',

        // Owner identity
        'owner_id_number',
        'owner_issue_date',
        'owner_expiry_date',
        'owner_front_image_url',
        'owner_back_image_url',

        // Registration
        'plate_number',
        'registration_issue_date',
        'registration_expiry_date',
        'registration_front_image_url',
        'registration_back_image_url',

        // Verification
        'verification_status',
        'rejection_reason',

    ];


    protected $casts = [

        'owner_issue_date' => 'date',

        'owner_expiry_date' => 'date',

        'registration_issue_date' => 'date',

        'registration_expiry_date' => 'date',

    ];


    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
