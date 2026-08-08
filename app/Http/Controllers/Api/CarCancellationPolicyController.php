<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\StoreCancellationPolicyRequest;
use App\Http\Requests\Car\UpdateCancellationPolicyRequest;
use App\Http\Resources\CarCancellationPolicyResource;
use App\Models\Car;
use App\Services\Car\CarCancellationPolicyService;
use App\Http\Responses\ApiResponse;

class CarCancellationPolicyController extends Controller
{

    public function __construct(
        private readonly CarCancellationPolicyService $policyService
    ) {
    }



    public function store(
        StoreCancellationPolicyRequest $request,
        Car $car
    )
    {


        $policy = $this->policyService->store(
            $car,
            $request->validated()
        );


        return ApiResponse::success(
            new CarCancellationPolicyResource($policy),
            __('car.policy_created')
        );

    }

    public function update(UpdateCancellationPolicyRequest $request, Car $car)
    {

        $policy = $this->policyService->update(
            $car->policy,
            $request->validated()
        );


        return ApiResponse::success(

            new CarCancellationPolicyResource($policy),

            __('car.policy_updated')

        );

    }


}
