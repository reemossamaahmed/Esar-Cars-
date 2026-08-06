<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\StoreCustomPriceRequest;
use App\Http\Requests\Car\UpdateCustomPriceRequest;
use App\Models\Car;
use App\Models\CarCustomPrice;
use App\Services\Car\CarCustomPriceService;
use App\Http\Resources\CarCustomPriceResource;
use App\Http\Responses\ApiResponse;


class CarCustomPriceController extends Controller
{


    public function __construct(private CarCustomPriceService $service)
    {
    }



    public function store(StoreCustomPriceRequest $request, Car $car)
    {

        $this->authorize(
            'update',
            $car
        );



        $customPrice =
            $this->service->create(
                $car,
                $request->validated()
            );



        return ApiResponse::success(

            new CarCustomPriceResource(
                $customPrice
            ),

            __('car.custom_price_created')

        );

    }

    public function update(UpdateCustomPriceRequest $request,Car $car, CarCustomPrice $customPrice)
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorize('update', $car);

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $customPrice = $this->service->update(

            $car,

            $customPrice,

            $request->validated()

        );

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */
        return ApiResponse::success(

            new CarCustomPriceResource($customPrice),

            __('car.custom_price_updated')

        );

    }

}
