<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'image_url' => $this->image_url,

            'is_cover' => $this->is_cover,

            'order_index' => $this->order_index,

        ];
    }
}
