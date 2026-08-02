<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarCustomPriceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'car_id' => $this->car_id,

            'date_from' => $this->date_from?->format('Y-m-d'),

            'date_to' => $this->date_to?->format('Y-m-d'),

            'daily_price' => $this->daily_price,

            'reason' => $this->reason->value,

            'created_at'        => $this->created_at?->format('Y-m-d'),

        ];
    }
}
