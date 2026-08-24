<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\CarHandoverPolicyRequest;
use App\Models\Car;
use App\Services\Car\CarHandoverPolicyService;
use App\Http\Responses\ApiResponse;

class CarHandoverPolicyController extends Controller
{
    public function store(CarHandoverPolicyRequest $request, CarHandoverPolicyService $service,Car $car)
    {

        $policy = $service->save(
            $car,
            $request->user(),
            $request->validated()
        );


        return ApiResponse::success(
            $policy,
            __('car_handover_policy.saved_successfully')
        );

    }

    public function show(
    Car $car, CarHandoverPolicyService $service)
    {

        $policy = $service->getPolicy($car);

        return ApiResponse::success(
            $policy,
            __('car_handover_policy.retrieved_successfully')
        );
    }
}
