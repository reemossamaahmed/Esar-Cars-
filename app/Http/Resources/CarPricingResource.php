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
            | External Booking
            |--------------------------------------------------------------------------
            */

            'external_booking_enabled' => $this->external_booking_enabled,



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

            'discount_rules' =>
                DiscountRuleResource::collection(
                    $this->whenLoaded('discountRules')
                ),


            'created_at' => $this->created_at?->format('Y-m-d'),

            'updated_at' => $this->updated_at?->format('Y-m-d'),

        ];
    }
}
