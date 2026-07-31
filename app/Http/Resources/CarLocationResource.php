<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarLocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'city' => [

                'id' => $this->city?->id,

                'name' => app()->getLocale() === 'ar'
                    ? $this->city?->name_ar
                    : $this->city?->name_en,

            ],


            'address' => $this->address,


            'latitude' => $this->latitude,


            'longitude' => $this->longitude,

        ];
    }
}
