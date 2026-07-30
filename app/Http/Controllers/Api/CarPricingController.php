<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\UpdateCarPricingRequest;
use App\Http\Responses\ApiResponse;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Services\Car\UpdateCarPricingService;

class CarPricingController extends Controller
{

    public function __construct(private UpdateCarPricingService $updateCarPricingService)
    {
    }



    public function update(UpdateCarPricingRequest $request, Car $car)
    {


        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorize('update', $car);



        $car = $this->updateCarPricingService->update(
            $car,
            $request->validated()
        );



        return ApiResponse::success(
            new CarResource($car),
            __('car.pricing_updated')
        );

    }

}
