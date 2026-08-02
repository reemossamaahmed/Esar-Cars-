<?php

namespace App\Services\Car;

use App\Models\Car;
use Illuminate\Validation\ValidationException;
use App\Models\CarPolicy;

class CarCancellationPolicyService
{


    public function store(Car $car, array $data): CarPolicy {


        if ($car->policy()->exists()) {

            throw ValidationException::withMessages([

                'policy' => [
                    __('car.policy_already_exists')
                ]

            ]);

        }



        return $car->policy()->create([

            'policy_text' => $data['policy_text'],

            'days_before' => $data['days_before'],

        ]);

    }

}
