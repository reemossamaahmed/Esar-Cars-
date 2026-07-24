<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GoogleLoginRequest;
use App\Services\GoogleAuthService;
use Illuminate\Http\JsonResponse;
Use App\Http\Responses\ApiResponse;
use App\Http\Resources\UserResource;

class GoogleAuthController extends Controller
{

    public function __construct(private GoogleAuthService $googleAuthService)
    {
    }

    public function login(GoogleLoginRequest $request): JsonResponse
    {
        $data = $this->googleAuthService
            ->authenticate($request->validated('id_token'));

        return ApiResponse::success(
            message: __('auth.login_successfully'),
            data: [
                'user' => new UserResource($data['user']),
                'token' => $data['token'],
            ]
        );
    }

}
