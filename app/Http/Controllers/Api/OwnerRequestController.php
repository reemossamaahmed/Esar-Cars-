<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OwnerRequest\StoreOwnerRequest;
use App\Http\Resources\OwnerRequestResource;
use App\Http\Responses\ApiResponse;
use App\Services\OwnerRequestService;
use App\Models\OwnerRequest;
use Illuminate\Http\Request;
use App\Http\Requests\OwnerRequest\RejectOwnerRequest;

class OwnerRequestController extends Controller
{
    public function __construct(private readonly OwnerRequestService $ownerRequestService)
    {
    }

    public function store(StoreOwnerRequest $request)
    {
        $ownerRequest = $this->ownerRequestService->createRequest(
            $request->user(),
            $request->validated()
        );

        return ApiResponse::success(
            new OwnerRequestResource($ownerRequest),
            __('owner_request.created_successfully'),
            201
        );
    }

    public function approve(Request $request, OwnerRequest $ownerRequest)
    {
        $ownerRequest = $this->ownerRequestService->approve($ownerRequest, $request->user());

        return ApiResponse::success(
            new OwnerRequestResource($ownerRequest),
            __('owner_request.approved_successfully')
        );
    }

    public function reject(RejectOwnerRequest $request,OwnerRequest $ownerRequest)
    {
        $ownerRequest = $this->ownerRequestService->reject($ownerRequest,auth('api')->user(),$request->validated()['rejection_reason']);

        return ApiResponse::success(
            new OwnerRequestResource($ownerRequest),
            __('owner_request.rejected_successfully')
        );
    }
}