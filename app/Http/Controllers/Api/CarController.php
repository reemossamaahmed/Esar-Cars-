<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\StoreCarRequest;
use App\Http\Resources\CarResource;
use App\Services\Car\CreateCarService;
use App\Http\Responses\ApiResponse;

class CarController extends Controller
{

    public function __construct(private CreateCarService $createCarService)
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

}
