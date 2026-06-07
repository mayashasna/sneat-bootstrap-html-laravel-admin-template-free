<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\UserLoginRequest;
use App\Http\Requests\User\Auth\UserRegisterRequest;
use App\Services\User\AuthService;
use App\Http\Requests\User\Auth\UserVerifyOtpRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Resources\UserResource;
class UserAuthController extends Controller
{
    use ApiResponse;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(UserRegisterRequest $request)
    {
        $response = $this->authService->register($request->validated());

        return $this->success(
            $response['message'],
            $response['data'] ?? null,
            $response['code']
        );
    }

    public function verifyOtp(UserVerifyOtpRequest $request)
{
    $response = $this->authService->verifyOtp($request->validated());

    if (! $response['status']) {
        return $this->error(
            $response['message'],
            $response['code']
        );
    }

    return $this->success(
        $response['message'],
        [
            'user'  => new UserResource($response['user']),
            'token' => $response['token']
        ],
        $response['code']
    );
}


    public function login(UserLoginRequest $request)
{
    $response = $this->authService->login($request->validated());

    if (! $response['status']) {
        return $this->error(
            $response['message'],
            $response['code']
        );
    }

    return $this->success(
        $response['message'],
        [
            'user'  => new UserResource($response['user']),
            'token' => $response['token']
        ],
        $response['code']
    );
}


    public function resendOtp(Request $request)
    {
        $response = $this->authService->resendOtp($request->all());

        return $this->success(
            $response['message'],
            $response['data'] ?? null,
            $response['code']
        );
    }
}
