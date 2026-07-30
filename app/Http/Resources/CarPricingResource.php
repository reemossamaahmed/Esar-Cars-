<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarPricingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'daily_price' => $this->daily_price,

            'weekly_price' => $this->weekly_price,

            'monthly_price' => $this->monthly_price,

            'down_payment' => $this->down_payment,

            'instant_booking_enabled' => $this->instant_booking_enabled,

        ];
    }
}
