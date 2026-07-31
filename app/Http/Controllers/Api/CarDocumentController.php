<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\StoreCarDocumentsRequest;
use App\Http\Resources\CarResource;
use App\Http\Responses\ApiResponse;
use App\Models\Car;
use App\Services\Car\UpdateCarDocumentsService;

class CarDocumentController extends Controller
{
    public function __construct(private UpdateCarDocumentsService $updateCarDocumentsService)
    {
    }

    public function update(StoreCarDocumentsRequest $request, Car $car)
    {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorize('update', $car);


        /*
        |--------------------------------------------------------------------------
        | Update Documents
        |--------------------------------------------------------------------------
        */

        $car = $this->updateCarDocumentsService->update(
            $car,
            $request->validated()
        );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return ApiResponse::success(
            new CarResource($car),
            __('car.documents_saved')
        );
    }
}
