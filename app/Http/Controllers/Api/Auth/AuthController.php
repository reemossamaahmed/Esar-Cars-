<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Http\Requests\Auth\ResendVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {}




    public function register(RegisterRequest $request) : JsonResponse
    {

        $result = $this->authService->register($request->validated());


        return ApiResponse::success(

            [

                'user' => new UserResource($result['user']),

            ],

            __('auth.register_success'),

            201
        );

    }

    public function login(LoginRequest $request): JsonResponse
    {

        $result = $this->authService
            ->login($request->validated());



        return ApiResponse::success(

            [

                'user'=>new UserResource($result['user']),

                'token'=>$result['token']

            ],

            __('auth.login_success')

        );

    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return ApiResponse::success(null, __('auth.logout_success'));
    }

    public function showProfile(Request $request): JsonResponse
    {
        return ApiResponse::success(

            new UserResource($request->user()),

            __('auth.profile_success')

        );
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {

        $user = $this->authService->updateProfile($request->user(),$request->validated());


        return ApiResponse::success(

            new UserResource($user),

            __('auth.profile_updated')

        );
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {

        $this->authService->changePassword(
            $request->user(),
            $request->validated()
        );


        return ApiResponse::success(null, __('auth.password_changed')
        );

    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {

        $this->authService->forgotPassword($request->validated());


        return ApiResponse::success(null, __('auth.otp_sent'));

    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {

        $this->authService->resetPassword(
            $request->validated()
        );


        return ApiResponse::success(
            null,
            __('auth.password_reset_success')
        );

    }

    public function verifyEmail(VerifyEmailRequest $request): JsonResponse
    {

        $this->authService->verifyEmail(
            $request->validated()
        );


        return ApiResponse::success(

            null,

            __('auth.email_verified'),

            200

        );

    }

    public function resendVerification(ResendVerificationRequest $request): JsonResponse
    {

        $result = $this->authService->resendVerification($request->validated());


        return ApiResponse::success(

            [
                'otp'=>$result
            ],

            __('auth.otp_sent'),

            200

        );

    }


}
