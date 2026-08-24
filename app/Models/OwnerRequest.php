<?php

namespace App\Models;

use App\Enums\OwnerRequestStatus;
use Illuminate\Database\Eloquent\Model;

class OwnerRequest extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'full_name',
        'phone',
        'national_id',
        'notes',
        'reviewed_by',
        'rejection_reason',
        'reviewed_at',
    ];

    protected $casts = [
        'status' => OwnerRequestStatus::class,
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class,'reviewed_by');
    }
}
