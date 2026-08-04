<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\StoreCarDocumentsRequest;
use App\Http\Resources\CarResource;
use App\Http\Responses\ApiResponse;
use App\Models\Car;
use App\Services\Car\CreateCarDocumentsService;

class CarDocumentController extends Controller
{
    public function __construct(private CreateCarDocumentsService $createCarDocumentsService)
    {
    }

    public function store(StoreCarDocumentsRequest $request, Car $car)
    {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        $this->authorize('manageDocuments', $car);


        /*
        |--------------------------------------------------------------------------
        | Update Documents
        |--------------------------------------------------------------------------
        */

        $car = $this->createCarDocumentsService->store(
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
