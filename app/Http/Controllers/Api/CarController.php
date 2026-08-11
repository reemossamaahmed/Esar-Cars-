<?php

namespace App\Http\Controllers\Api;

use App\Models\Car;
use App\Http\Controllers\Controller;
use App\Http\Requests\Car\StoreCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Services\Car\CarService;
use App\Http\Responses\ApiResponse;

class CarController extends Controller
{



    public function __construct(private CarService $carService)
    {
    }


    public function store(StoreCarRequest $request)
    {

        $car = $this->carService->create($request->validated());


        return ApiResponse::success(
            new CarResource($car),
            __('car.basic_information_saved')
        );

    }

    public function update(UpdateCarRequest $request, Car $car)
    {

        $car = $this->carService
            ->update(
                $car,
                $request->validated()
            );


        return ApiResponse::success(
            new CarResource($car),
            __('car.updated_successfully')
        );

    }

    public function show(Car $car)
    {
        $this->authorize('view', $car);
        
        $car->load([
            'brand',
            'carModel',
            'carType',
            'features',
            'location',
            'pricing',
            'customPrices',
            'images',
            'policy',
        ]);

        return ApiResponse::success(
            new CarResource($car),
            __('car.retrieved_successfully')
        );
    }

}
