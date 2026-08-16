<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CarModelLookupResource;
use App\Http\Resources\CarTypeLookupResource;
use App\Http\Resources\CityLookupResource;
use App\Http\Resources\FeatureResource;
use App\Http\Responses\ApiResponse;
use App\Services\Lookup\LookupService;

class LookupController extends Controller
{
    public function __construct(private readonly LookupService $lookupService)
    {
    }

    public function brands()
    {
        $brands = $this->lookupService->brands();

        return ApiResponse::success(
            BrandResource::collection($brands),
            __('lookup.brands_retrieved_successfully')
        );
    }

    public function carModels()
    {
        $models = $this->lookupService->carModels();

        return ApiResponse::success(
            CarModelLookupResource::collection($models),
            __('lookup.car_models_retrieved_successfully')
        );
    }

    public function carTypes()
    {
        $carTypes = $this->lookupService->carTypes();

        return ApiResponse::success(
            CarTypeLookupResource::collection($carTypes),
            __('lookup.car_types_retrieved_successfully')
        );
    }

    public function cities()
    {
        $cities = $this->lookupService->cities();

        return ApiResponse::success(
            CityLookupResource::collection($cities),
            __('lookup.cities_retrieved_successfully')
        );
    }

    public function features()
    {
        $features = $this->lookupService->features();

        return ApiResponse::success(
            FeatureResource::collection($features),
            __('lookup.features_retrieved_successfully')
        );
    }
}
