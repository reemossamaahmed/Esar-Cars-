<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\StoreCustomPriceRequest;
use App\Http\Resources\CarResource;
use App\Http\Responses\ApiResponse;
use App\Models\Car;
use App\Services\Car\CreateCustomPriceService;

class CarCustomPriceController extends Controller
{
    public function __construct(
        private CreateCustomPriceService $createCustomPriceService
    ) {
    }

    public function store(
        StoreCustomPriceRequest $request,
        Car $car
    ) {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorize('update', $car);

        /*
        |--------------------------------------------------------------------------
        | Create Custom Price
        |--------------------------------------------------------------------------
        */

        $car = $this->createCustomPriceService->create(
            $car,
            $request->validated()
        );

        return ApiResponse::success(
            new CarResource($car),
            __('car.custom_price_created')
        );
    }
}
