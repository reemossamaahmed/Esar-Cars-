<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountRuleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'min_days' => $this->min_days,

            'discount_percent' => $this->discount_percent,

        ];
    }
}
