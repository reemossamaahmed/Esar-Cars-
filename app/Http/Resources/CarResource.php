<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CarImageResource;

class CarResource extends JsonResource
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
            | Owner
            |--------------------------------------------------------------------------
            */

            'owner_id' => $this->owner_id,


            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            'brand' => [
                'id' => $this->brand?->id,

                'name' => app()->getLocale() === 'ar'
                        ? $this->brand?->name_ar
                        : $this->brand?->name_en,
            ],


            'model' => [
                'id' => $this->carModel?->id,

                'name' => app()->getLocale() === 'ar'
                    ? $this->carModel?->name_ar
                    : $this->carModel?->name_en,
            ],


            'car_type' => [
                'id' => $this->carType?->id,

                'name' => app()->getLocale() === 'ar'
                    ? $this->carType?->name_ar
                    : $this->carType?->name_en,
            ],


            'year' => $this->year,

            'chassis_number' => $this->chassis_number,

            'seats_count' => $this->seats_count,

            'insurance_value' => $this->insurance_value,


            'transmission' => $this->transmission,

            'drivetrain' => $this->drivetrain,

            'color' => $this->color,

            'km_driven' => $this->km_driven,


            'description' => $this->description,

            'video_url' => $this->video_url,


            'images' => CarImageResource::collection(
                $this->whenLoaded('images')
            ),


            /*
            |--------------------------------------------------------------------------
            | Prices
            |--------------------------------------------------------------------------
            */


            'pricing' => new CarPricingResource(
                $this->whenLoaded('pricing')
            ),


            /*
            |--------------------------------------------------------------------------
            | Discount Rules
            |--------------------------------------------------------------------------
            */

            'discount_rules' => DiscountRuleResource::collection(
                $this->whenLoaded('discountRules')
            ),



            /*
            |--------------------------------------------------------------------------
            | Features
            |--------------------------------------------------------------------------
            */

            'features' => FeatureResource::collection(
                $this->whenLoaded('features')
            ),



            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            'location' => new CarLocationResource(
                $this->whenLoaded('location')
            ),


            /*
            |--------------------------------------------------------------------------
            | Policy
            |--------------------------------------------------------------------------
            */


            'cancellation_policy' => new CarCancellationPolicyResource(
                $this->whenLoaded('policy')
            ),



            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' => $this->status,

            'published_at' => $this->published_at,


            /*
            |--------------------------------------------------------------------------
            | Rating
            |--------------------------------------------------------------------------
            */

            'rating' => [
                'average' => $this->rating_avg,
                'count' => $this->rating_count,
            ],


            'created_at' => $this->created_at?->format('Y-m-d'),

        ];
    }
}
