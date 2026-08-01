<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarPricingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,


            /*
            |--------------------------------------------------------------------------
            | Prices
            |--------------------------------------------------------------------------
            */

            'daily_price' => $this->daily_price,

            'monthly_price' => $this->monthly_price,

            'yearly_price' => $this->yearly_price,



            /*
            |--------------------------------------------------------------------------
            | Booking
            |--------------------------------------------------------------------------
            */

            'instant_booking_enabled'
                => $this->instant_booking_enabled,



            /*
            |--------------------------------------------------------------------------
            | Deposit
            |--------------------------------------------------------------------------
            */

            'deposit' => [

                'title'
                    => $this->deposit_title,

                'description'
                    => $this->deposit_description,

                'price'
                    => $this->deposit_price,

            ],



            /*
            |--------------------------------------------------------------------------
            | Offers
            |--------------------------------------------------------------------------
            */

            'discount_rules'
                => $this->whenLoaded(
                    'discountRules'
                ),



            'created_at'
                => $this->created_at,

            'updated_at'
                => $this->updated_at,

        ];
    }
}
