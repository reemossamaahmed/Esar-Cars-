<?php

namespace App\Models;

use App\Enums\DocumentStatus;
use Illuminate\Database\Eloquent\Model;

class OwnerDocument extends Model
{
    /**
     * Mass Assignment
     */
    protected $fillable = [

        'user_id',

        'national_id',

        'issue_city_id',

        'issue_date',

        'expiry_date',

        'id_card_image_url',

        'status',

        'verified_at',

    ];

    /**
     * Casts
     */
    protected $casts = [

        'issue_date'   => 'date',

        'expiry_date'  => 'date',

        'verified_at'  => 'datetime',

        'status'       => DocumentStatus::class,

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function issueCity()
    {
        return $this->belongsTo(City::class, 'issue_city_id');
    }
}
