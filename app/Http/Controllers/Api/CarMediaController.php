<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\StoreCarMediaRequest;
use App\Http\Requests\Car\UpdateCarMediaRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Services\Car\CarMediaService;
use App\Http\Responses\ApiResponse;

class CarMediaController extends Controller
{

    public function __construct(private readonly CarMediaService $mediaService)
    {
    }



    public function store(StoreCarMediaRequest $request, Car $car)
    {

        $car = $this->mediaService->store(
            $car,
            $request->validated()
        );


        return ApiResponse::success(
            new CarResource($car),
            __('car.media_added')
        );

    }



    public function update(UpdateCarMediaRequest $request, Car $car)
    {

        $car = $this->mediaService->update($car, $request->validated());


        return ApiResponse::success(
            new CarResource($car),
            __('car.media_updated')
        );

    }

}
