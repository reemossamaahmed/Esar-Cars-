<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\StoreCarPricingRequest;
use App\Http\Requests\Car\UpdateCarPricingRequest;
use App\Http\Resources\CarPricingResource;
use App\Http\Responses\ApiResponse;
use App\Models\Car;
use App\Services\Car\CarPricingService;

class CarPricingController extends Controller
{

    public function __construct(private CarPricingService $carPricingService)
    {
    }



    public function store(StoreCarPricingRequest $request, Car $car)
    {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorize('update', $car);



        /*
        |--------------------------------------------------------------------------
        | Update Pricing
        |--------------------------------------------------------------------------
        */

        $pricing = $this->carPricingService->create(
            $car,
            $request->validated()
        );



        return ApiResponse::success(

            new CarPricingResource($pricing),

            __('car.pricing_created')

        );

    }

    public function update(UpdateCarPricingRequest $request, Car $car)
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorize('update', $car);



        /*
        |--------------------------------------------------------------------------
        | Update Pricing
        |--------------------------------------------------------------------------
        */

        $pricing = $this->carPricingService->update(
            $car,
            $request->validated()
        );



        return ApiResponse::success(

            new CarPricingResource($pricing),

            __('car.pricing_updated')

        );
    }

}
