<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OwnerRequest\StoreOwnerDocumentRequest;
use App\Http\Responses\ApiResponse;
use App\Services\OwnerDocumentService;

class OwnerDocumentController extends Controller
{
    public function __construct(private readonly OwnerDocumentService $ownerDocumentService)
    {
    }

    public function store(StoreOwnerDocumentRequest $request)
    {
        $document = $this->ownerDocumentService->store(
            auth('api')->user(),
            $request->validated()
        );

        return ApiResponse::success(
            $document,
            __('owner_request.documents_saved')
        );
    }
}