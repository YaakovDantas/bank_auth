<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function login(AuthRequest $request)
    {
        try {
            $credentials = request(['name', 'password']);
            
            $this->authService->validateCredentials($credentials);

            $tokenResult = $this->authService->createToken($request->user());

            return [
                'access_token' => $tokenResult,
                'status' => 200,
                'token_type' => 'Bearer',
                'token_expired' => config('sanctum.expiration') * 60
            ];

        } catch (\Exception $exception) {
            return [
                "msg" => 'fail.login',
                "status" => 422,
                "success" => false
            ];
        }
    }

    public function logout()
    {
        try {
            $user = $this->authService->userFromAccessToken(request()->bearerToken());

            $this->authService->revokeAllTokens($user);

            return [
                'revoked_token' => request()->bearerToken()
            ];

        } catch (\Exception $exception) {
            return [
                "msg" => 'fail.logout',
                "status" => 422,
                "success" => false
            ];
        }
    }

    public function getUserByToken()
    {
        $result = $this->authService->userFromAccessToken(request()->bearerToken());
        return new UserResource($result);
    }
}