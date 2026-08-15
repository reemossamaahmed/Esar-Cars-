<?php

namespace App\Services\Car;

use App\Models\Car;
use Illuminate\Validation\ValidationException;
use App\Models\CarPolicy;
use App\Enums\CarStatus;

class CarCancellationPolicyService
{

    public function store(Car $car, array $data): CarPolicy
    {
        if ($car->policy()->exists()) {
            throw ValidationException::withMessages([
                'policy' => [
                    __('car.policy_already_exists')
                ]
            ]);
        }

        $policy = $car->policy()->create([
            'policy_text' => $data['policy_text'],
            'days_before' => $data['days_before'],
            'is_active' => $data['is_active'] ?? true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Publish Car
        |--------------------------------------------------------------------------
        */

        if ($data['publish']) {
            $car->update([
                'status' => CarStatus::PUBLISHED,
                'published_at' => now(),
            ]);
        } else {
            $car->update([
                'status' => CarStatus::DRAFT,
                'published_at' => null,
            ]);
        }

        return $policy->refresh();
    }

    public function update(CarPolicy $policy, array $data): CarPolicy
    {
        $publish = $data['publish'] ?? null;

        unset($data['publish']);

        $policy->update($data);

        if ($publish !== null) {
            $car = $policy->car;

            if ($publish) {
                $car->update([
                    'status' => CarStatus::PUBLISHED,
                    'published_at' => $car->published_at ?? now(),
                ]);
            } else {
                $car->update([
                    'status' => CarStatus::DRAFT,
                    'published_at' => null,
                ]);
            }
        }

        return $policy->refresh();
    }

}
