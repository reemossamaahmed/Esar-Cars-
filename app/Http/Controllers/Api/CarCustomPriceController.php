<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\StoreCustomPriceRequest;
use App\Models\Car;
use App\Services\Car\CreateCustomPriceService;
use App\Http\Resources\CarCustomPriceResource;
use App\Http\Responses\ApiResponse;


class CarCustomPriceController extends Controller
{


    public function __construct(private CreateCustomPriceService $service)
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

}
