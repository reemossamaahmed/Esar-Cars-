<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarCancellationPolicyResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'policy_text' => $this->policy_text,

            'days_before' => $this->days_before,

        ];
    }

}
