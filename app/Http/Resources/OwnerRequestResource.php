<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'status' => $this->status->value,

            'full_name' => $this->full_name,

            'phone' => $this->phone,

            'national_id' => $this->national_id,

            'notes' => $this->notes,

            'rejection_reason' => $this->rejection_reason,

            'reviewed_at' => $this->reviewed_at?->format(
                'Y-m-d H:i:s'
            ),

            'created_at' => $this->created_at?->format(
                'Y-m-d H:i:s'
            ),
        ];
    }
}