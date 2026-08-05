<?php

namespace App\Http\Controllers\Api;

use App\Models\Car;
use App\Http\Controllers\Controller;
use App\Http\Requests\Car\StoreCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Services\Car\CreateCarService;
use App\Services\Car\UpdateCarService;
use App\Http\Responses\ApiResponse;

class CarController extends Controller
{



    public function __construct(private CreateCarService $createCarService, private UpdateCarService $updateCarService)
    {
    }


    public function store(StoreCarRequest $request)
    {

        $car = $this->createCarService->create($request->validated());


        return ApiResponse::success(
            new CarResource($car),
            __('car.basic_information_saved')
        );

    }

    public function update(UpdateCarRequest $request, Car $car)
    {

        $car = $this->updateCarService
            ->update(
                $car,
                $request->validated()
            );


        return ApiResponse::success(
            new CarResource($car),
            __('car.updated_successfully')
        );

    }

}
